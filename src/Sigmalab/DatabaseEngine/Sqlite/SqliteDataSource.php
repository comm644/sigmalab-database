<?php
declare(strict_types=1);

namespace Sigmalab\DatabaseEngine\Sqlite;

use Closure;
use DSN;
use Exception;
use Sigmalab\Database\Core\DataSourceLogger;
use Sigmalab\Database\Core\DBDataSource;
use Sigmalab\Database\Core\DBDefaultResultContainer;
use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\DBRowsAffectedResult;
use Sigmalab\Database\Core\DBTransactionControl;
use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementSelectResult;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use SQLite3;
use SQLite3Result;
use SQLite3Stmt;

require_once(__DIR__ . "/../../../../DSN.php");

class SqliteDataSource extends DBDataSource
{
	use DBTransactionControl;

	private const SQLITE_LOWALPHA = "абвгдеёжзийклмнорпстуфхцчшщъьыэюя";
	private const SQLITE_HIALPHA = "АБВГДЕЁЖЗИЙКЛМНОРПСТУФХЦЧШЩЪЬЫЭЮЯ";


	/**
	 * Link object
	 *
	 * @var SQLite3
	 */
	protected ?SQLite3 $link = null;

	protected array $preparedStm = [];

	private ?SQLStatement $lastStm = null;
	private bool $isUseSafeStrings = false;
	private string $uid = "";

	public function __construct()
	{
		$this->preparedStm = array();
		$this->uid = $this->uuid();
	}

	public function destruct(): void
	{
		if (!$this->link) {
			return;
		}

		if ($this->inTransaction()) {
			if ($this->inTransaction()) {
				$this->getLogger()->notice("commit on destroy");
				try {
					$this->linkCommitTransaction();;
				} catch (\Exception $e) {
				}
			}
			$rc = $this->link->close();
			if ($rc === false) {
				$this->getLogger()->notice("Close link - fail");
			}
		}
		$this->link = null;
	}


	public function __destruct()
	{
		$this->destruct();
	}

	/**
	 * connect to database
	 *
	 * @param string $dsn DSN  such as: "sqlite://localhost//?database=path/to/database.db"
	 * @return int  DS_SUCCESS or error
	 */
	public function connect(string $dsn)
	{
		$logger = $this->getLogger();
		$logger->debug("connecting to $dsn");
		$this->setConnectString($dsn);

		$dsn = new DSN($dsn);
		$method = $dsn->getMethod();
		if ($method !== "sqlite") {
			return $this->errorMethodNotSupported($method);
		}

		$file = $dsn->getDatabase();

		// Connecting, selecting database
		$this->link = null;
		$this->preparedStm = array();
		$this->link = new SQLite3($file, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		$this->link->enableExceptions(true);;
		$this->link->busyTimeout(1000);
		//$this->link->querySingle("PRAGMA journal_mode = MEMORY");

		$rc = $this->link->createFunction('ru_upper', function ($string) {
			$string = strtr($string, self::SQLITE_LOWALPHA, self::SQLITE_HIALPHA);
			$rc = strtoupper($string);
			return $rc;
		});

		if ($rc === false) {
			$logger->warning("Can't create collation for ru_RU");
		}
		return (DS_SUCCESS);
	}

	public function getEngineError()
	{
		$rc = $this->link->lastErrorCode();
		if (!$rc) return 'Success.';
		return $this->link->lastErrorMsg();
	}

	public function getEngineName()
	{

		return ("Sqlite3");
	}

	public function isLinkAvailable()
	{
		return $this->link != null;
	}

	/**
	 * returns SQL geenrator.
	 *
	 * @return SQLGenerator
	 */
	public function getGenerator()
	{
		return new SqliteGenerator();
	}

	/**
	 * Gets logger intsance
	 * @return DataSourceLogger
	 */
	public function getLogger()
	{
		return DataSourceLogger::getInstance();
	}

	/** query "SELECT" to container
	 * @param string $query SQL query
	 * @param DBResultContainer $resultContainer
	 * @return int zero on success
	 * @throws DatabaseException
	 * @see DBDefaultResultContainer
	 * @see DBResultcontainer
	 */
	public function querySelect(string $query, DBResultContainer $resultContainer): int
	{
		try {
			log_info("{$query} link:".$this->uid);
			$resultStm = $this->link->query($query . ";");
		} catch (Exception $e) {
			echo "Error in statement: $query:" . $e->getMessage();
		}
		return $this->_processSelectResult($resultStm, $resultContainer, $query);
	}

	/**
	 * @param SQLite3Result $driverResult
	 * @param DBResultcontainer $resultContainer
	 * @param $query
	 * @return int
	 * @throws DatabaseException
	 */
	protected function _processSelectResult(SQLite3Result $driverResult, &$resultContainer, $query)
	{
		if (!$driverResult) {
			throw new DatabaseException("Query error: {$this->getEngineError()}\nQuery: $query ");
		}
		$count = 0;
		while (($row = $driverResult->fetchArray(SQLITE3_NUM)) !== false) {
			$obj = $resultContainer->fromSQL($row);
			$resultContainer->add($obj);
			$count++;
		}
		if ($this->signDebugQueries) {
			$this->getLogger()->debug("select result: $count items");
		}
		$driverResult->finalize();

		return 0;
	}


	/**
	 * @param string $query
	 * @param DBResultContainer $resultContainer
	 * @return int
	 * @throws DatabaseException
	 */
	public function querySelectEx(string $query, DBResultContainer $resultContainer): int
	{
		return $this->querySelect($query, $resultContainer);
	}

	/** query "INSERT/UPDATE/DELETE"
	 * @param string $query SQL query
	 * @param DBResultContainer|DBDefaultResultContainer|SQLStatementSelectResult $resultContainer container strategy. method must returns count for affected rows as result set
	 * @return int  0 on success or error code
	 * @throws DatabaseBusyException
	 */
	public function queryCommand(string $query, DBResultContainer $resultContainer)
	{
		try {
			$this->getLogger()->notice("{$query} link:".$this->uid);
			//$driverStm = $this->link->prepare($query . ";");

			$rc = $this->link->exec($query . ";");
			$resultContainer->add(new DBRowsAffectedResult((int)$rc));
		} catch (\Exception $e) {
			if (($e->getCode() == "HY000") && (strstr($e->getMessage(), "locked") !== false)) {
				$this->getLogger()->warning("locked...");
				throw new DatabaseBusyException($e->getMessage());
			} else {
				$this->getLogger()->error($query);
			}
			throw $e;
		}

		return 0;
	}


	/**
	 * Execute statement.
	 *
	 * This method cabe overriden in inherit class for special procesing statements.
	 *
	 * @access protected.
	 * @param SQLStatement|SQLStatementSelect|SQLStatementInsert|SQLStatementUpdate $stm
	 * @param DBResultcontainer|DBDefaultResultContainer|SQLStatementSelectResult $resultContainer contaner stategy
	 * @return int|SQLite3Result|null
	 * @throws DatabaseException
	 * @throws DatabaseBusyException
	 * @throws Exception
	 */
	protected function _executeStatement(SQLStatement $stm, DBResultContainer $resultContainer)
	{
		//process query
		//$rc = false;
		$generator = $this->getGenerator();

		$class = get_class($stm);
		$driverResult = null;
		if ($stm instanceof SQLStatementSelect) {
			try {
				/** @var SQLite3Stmt $driverStm */
				$driverStm = $this->_prepareStatement($stm);
				$driverResult = $driverStm->execute();
				$driverResult = $this->_processSelectResult($driverResult, $resultContainer, "SQL query");
			} catch (\Exception $e) {
				$message = $this->getStmErrorMessage($stm, $e);
//				if (php_sapi_name() == "cli") {
//					print_r($message);
//				}
				$generator = $this->getGenerator();
				$query = $generator->generateParametrizedQuery($stm);
				$sql = $query->getQuery();
				$message .= "Parametrised query: $sql";
				throw new DatabaseException($message);
			}
		} else if ($stm instanceof SQLStatementDelete) {

			$sql = $generator->generate($stm);
			try {
				$driverStm = $this->link->prepare($sql . ";");
			} catch (\Exception $e) {
				throw new DatabaseException("Can't prepare statement: $sql\nError: " . $e->getMessage());
			}

			if (!$driverStm) {
				throw new DatabaseException("Can't prepare statement: $sql\nError: " . $this->getEngineError());
			}

			$this->repeatWhenLocked(function () use ($driverStm, &$resultContainer, &$driverResult) {
				$driverResult = $driverStm->execute();
				$resultContainer->add(new DBRowsAffectedResult($this->link->changes()));
			}, function () {
			});
		} else if (($stm instanceof SQLStatementUpdate)
			|| ($stm instanceof SQLStatementInsert)) {

			$driverResult = null;

			/** @var SQLite3Stmt $driverStm */
			$driverStm = null;
			$this->repeatWhenLocked(
				function () use (&$driverStm, &$driverResult, $stm, $resultContainer) {
					$driverStm = $this->_prepareStatement($stm);
					$class = get_class($stm->object);
					$this->getLogger()->notice("{$stm->sqlStatement} {$stm->table} ({$class}) link:".$this->uid);
					$driverResult = $driverStm->execute();
					$driverStm->reset();
					//not need fetch result it causes executing query twice.
					$resultContainer->add(new DBRowsAffectedResult($this->link->changes()));
				},
				function () use (&$driverStm, $stm) {
					$this->getLogger()->warning('exception. ' . $stm->generate($this->getGenerator()));
					$this->resetLastPdoStm();
				});
			if  ($stm instanceof SQLStatementInsert) {
				$driverResult = $this->link->lastInsertRowID();
			}
		} else {
			throw new DatabaseException("Don't know how to execute  $class");
		}
		return $driverResult;
	}


	/**
	 * @param SQLite3Result $driverResult
	 * @return array
	 */
	private function readAllRows(SQLite3Result $driverResult): array
	{
		$rows = [];
		while (($row = $driverResult->fetchArray(SQLITE3_NUM)) !== false) {
			$rows[] = $row;
		}
		$driverResult->finalize();
		return $rows;
	}

	/**
	 * @param $pdoStm
	 * @return array
	 * @throws DatabaseException
	 */
	public function doExecuteStm(SQLStatement $stm)
	{
		return [];
	}

	private function resetLastPdoStm()
	{
		$this->getLogger()->warning('reset last sql:' . $this->lastSql);
		unset($this->preparedStm[$this->lastSql]);
	}

	public string $lastSql = '';

	/**
	 * @param SQLStatement $stm
	 * @return SQLite3Stmt
	 * @throws DatabaseException
	 */
	public function _prepareStatement(SQLStatement $stm): SQLite3Stmt
	{
		$generator = $this->getGenerator();
		$query = $generator->generateParametrizedQuery($stm);
		$sql = $query->getQuery();

		if ($this->signShowQueries) {
			print_r($query);
		}
		if ($this->signDebugQueries) {
			$this->getLogger()->debug($query->toString());
		}

		$this->lastStm = $stm;
		$this->lastSql = $sql;

		if (!isset($this->preparedStm[$sql])) {
			/** @var SQLite3Stmt $driverStm */
			$driverStm = null;
			$driverStm = $this->link->prepare($sql . ";");
			$this->preparedStm[$sql] = $driverStm;
		} else {
			$driverStm = $this->preparedStm[$sql];
		}

		$driverStm->clear();
		foreach ($query->getParameters() as $param) {
			$type = $this->_getType($param->type);
			if ($this->isUseSafeStrings) {
				if ($param->type === DBParamType::String) {
					if (strpos($param->value, "\0") !== false) {
						$type = SQLITE3_BLOB;
					}
				}
			}
			$rc = $driverStm->bindValue($param->name, $param->value, $type);

			if ($rc === false) {
				throw new DatabaseException("Can't bind value to statement: $sql\nError: " . $this->getEngineError());
			}
		}
		return $driverStm;
	}

	/**
	 * Get Sqlite3 type from Temis.ADO type
	 *
	 * @param string $sqlType Temis.ADO type
	 * @access private
	 */
	protected function _getType($sqlType):int
	{
		$map = array(
			DBParamType::Integer => SQLITE3_INTEGER,
			DBParamType::String => SQLITE3_TEXT,
			DBParamType::Lob => SQLITE3_BLOB,
			DBParamType::Bool => SQLITE3_INTEGER,
			DBParamType::Null => SQLITE3_NULL,
			DBParamType::Real => SQLITE3_FLOAT
		);

		if (!array_key_exists($sqlType, $map)) return SQLITE3_TEXT;
		return $map[$sqlType];
	}

	/**
	 * Gets last intsert ID.
	 * @return int
	 * @access public
	 */
	public function lastID(): int
	{
		assert($this->link != null);
		return (int)$this->link->lastInsertRowID();
	}

	/** Run method and process locked database state
	 *
	 * @param Closure $method target method
	 * @param Closure $whenLocked method which need to call when database locked, for retry
	 * @throws Exception
	 * @throws DatabaseBusyException
	 * @throws DatabaseException
	 */
	public function repeatWhenLocked(\Closure $method, \Closure $whenLocked)
	{
		for ($attempt = 0; $attempt < 5; ++$attempt) {
			try {
				$method();
				return;
			} catch (\Exception $e) {
				$lastError = $this->link->lastErrorCode();
				if ($lastError == 5) {
					$this->getLogger()->warning("locked $attempt. sleep...");
					$whenLocked();
					sleep(1);
					continue;
				}
				$this->getLogger()->warning("Database exception: code={$lastError} msg={$this->link->lastErrorMsg()}");
				$message = $this->getStmErrorMessage($this->lastStm, $e);
				throw new DatabaseException($message);
			}
		}

		$this->getLogger()->warning("Database locked $attempt tries. Fire timeout exception");
		throw new DatabaseBusyException("Database locked");
	}

	/**
	 * @param $stm
	 * @param Exception $e
	 * @return string
	 */
	protected function getStmErrorMessage(SQLStatement $stm, Exception $e): string
	{
		$generator = $this->getGenerator();
		$message = "Can't execute statement from:\n $stm->cacheKey\n"
			. " {$stm->generate($generator)} \n\n"
			. "Error: "
			. $e->getMessage()
			. " from " . $e->getFile() . ':' . $e->getLine();
		return $message;
	}

	protected function linkCommitTransaction(): void
	{
		$this->getLogger()->notice("commit link:".$this->uid);
		$this->repeatWhenLocked(function () {
			$this->link->querySingle("COMMIT;");
		}, function () {
		});
	}

	protected function linkRollbackTransaction(): void
	{
		$this->getLogger()->notice("link:".$this->uid);
		if  ($this->inTransaction()) {
			$this->link->querySingle("ROLLBACK TRANSACTION;");
		}
	}

	protected function linkBeginTransaction(): void
	{
		$this->getLogger()->notice("begin link:".$this->uid);
		$this->repeatWhenLocked(function () {
			$this->link->querySingle("BEGIN TRANSACTION;");
		}, function () {
		});
	}

	/**
	 * full copyright in modules/uuid
	 *
	 * @copyright   Copyright (c) CFD Labs, 2006. This function may be used freely for
	 *              any purpose ; it is distributed without any form of warranty whatsoever.
	 * @author      David Holmes <dholmes@cfdsoftware.net>
	 *
	 * @return  string  A UUID, made up of 32 hex digits and 4 hyphens.
	 */
	private function uuid() :string{

		// The field names refer to RFC 4122 section 4.1.2

		return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
			mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			mt_rand(0, 65535), // 16 bits for "time_mid"
			mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
		);
	}


}


