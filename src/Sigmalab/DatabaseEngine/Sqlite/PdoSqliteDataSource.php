<?php
declare(strict_types=1);

namespace Sigmalab\DatabaseEngine\Sqlite;

use Closure;
use Diagnostics;
use DSN;
use Exception;
use PDO;
use PDOException;
use PDOStatement;
use Sigmalab\Database\Core\DataSourceLogger;
use Sigmalab\Database\Core\DBDataSource;
use Sigmalab\Database\Core\DBDefaultResultContainer;
use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\DBRowsAffectedResult;
use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementSelectResult;
use Sigmalab\Database\Sql\SQLStatementUpdate;

require_once(__DIR__ . "/../../../../DSN.php");

define("SQLITE_LOWALPHA", "абвгдеёжзийклмнорпстуфхцчшщъьыэюя");
define("SQLITE_HIALPHA", "АБВГДЕЁЖЗИЙКЛМНОРПСТУФХЦЧШЩЪЬЫЭЮЯ");

function sqlite_ru_upper($string)
{
	$string = strtr($string, SQLITE_LOWALPHA,SQLITE_HIALPHA);
	$rc = strtoupper($string );
	return $rc;
}

class PdoSqliteDataSource extends DBDataSource
{
	/**
	 * Link object (PDO)
	 *
	 * @var PDO
	 */
	protected ?PDO $link = null;

	protected array $preparedStm = [];

	protected int $transactionLevel = 0;

	public function __construct()
	{
		$this->preparedStm = array();

	}

	public function __destruct()
	{
		try {
			if ($this->link) {
				if ($this->link->inTransaction()) {
					$this->link->commit();
				}
				$this->link->setAttribute(PDO::ATTR_PERSISTENT, false);
			}
		}
		catch (PDOException $e){
			
		}
		$this->link = null;
	}

	/**
	 * connect to database
	 *
	 * @param string $dsn DSN  such as: "sqlite://localhost//?database=path/to/database.db"
	 * @return integer  DS_SUCCESS or error
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
		try {
			$this->link = null;
			$this->preparedStm = array();
			$this->link = new PDO("sqlite:$file", "");
//			$this->link = new PDO( "sqlite:$file", "", "", array(PDO::ATTR_PERSISTENT => true));
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE );
			$this->link->setAttribute(PDO::ATTR_PERSISTENT, false);
			$this->link->setAttribute(PDO::ATTR_TIMEOUT, 5);
			//$this->link->query("PRAGMA journal_mode = MEMORY");
		} catch (PDOException $exception) {
			$this->registerError("", "Can't connect to '{$file}':{$exception->getMessage()} ");
			throw new DatabaseException($exception->getMessage() . "$file");
		}

		$rc = $this->link->sqliteCreateFunction('ru_upper', function ($string) {
			$string = strtr($string, SQLITE_LOWALPHA, SQLITE_HIALPHA);
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
		$info = $this->link->errorInfo();
		if ($info[0] == '00000') return 'Success.';
		return $info[2];
	}

	public function getEngineName()
	{

		return ("PDO(sqlite)");
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
		$resultStm = $this->link->query($query . ";", PDO::FETCH_CLASS, "stdclass");
		return $this->_processSelectResult($resultStm, $resultContainer, $query);
	}

	/**
	 * @param PDOStatement $resultStm
	 * @param DBResultcontainer $resultContainer
	 * @param $query
	 * @return int
	 * @throws DatabaseException
	 */
	protected function _processSelectResult(PDOStatement $resultStm, &$resultContainer, $query)
	{
		if (!$resultStm) {
			throw new DatabaseException("PDO query error: {$this->getEngineError()}\nQuery: $query ");
		}
		$count = 0;
		foreach ($resultStm->fetchAll(PDO::FETCH_NUM) as $row) {
			$obj = $resultContainer->fromSQL($row);
			$resultContainer->add($obj);
			$count++;
		}
		if ($this->signDebugQueries) {
			$this->getLogger()->debug("select result: $count items");
		}
		if ($this->signShowQueries) {
			echo "Select result: $count items\n";
		}

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
			$rowsAffected = $this->link->exec($query . ";");
			$result = new DBRowsAffectedResult($rowsAffected);
			$resultContainer->add($result);
		} catch (PDOException $e) {
			if (($e->getCode() === "HY000") && (strstr($e->getMessage(), "locked") !== false)) {
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
	 * @return int|null
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
		$rc = null;
		if  ($stm instanceof SQLStatementSelect ) {
			for (; ;) {
				try {
					/** @var PDOStatement $pdoStm */
					$pdoStm = $this->_preparePdoStatement($stm);
					$pdoStm->execute();
					$rc = $this->_processSelectResult($pdoStm, $resultContainer, "SQL query");
				} catch (\Exception $e) {
					if ($e->getCode() == 5) {
						if (strstr($e->getMessage(), "locked") !== false) {
							continue;
						}
					}

					$message = "Can't execute statement from $stm->cacheKey\n"
						. " {$stm->generate($generator)} \n==\n {$stm->querySql}\n\n"
						. "params:" . count($stm->queryParams)
						. "Error: "
						. $e->getMessage()
						. " from " . $e->getFile() . ':' . $e->getLine();
					if (php_sapi_name() == "cli") {
						print_r($message);
					}
					throw new DatabaseException(
						$message
					);
				}
				break;
			}
		}
		else if ( $stm instanceof SQLStatementDelete ) {

			$sql = $generator->generate($stm);
			try {
				$pdoStm = $this->link->prepare($sql . ";");
			} catch (PDOException $e) {
				throw new DatabaseException("Can't prepare statement: $sql\nError: " . $e->getMessage());
			}

			if (!$pdoStm) {
				throw new DatabaseException("Can't prepare statement: $sql\nError: " . $this->getEngineError());
			}

			$this->repeatWhenLocked(function () use ($pdoStm, &$rowsAffected, &$resultContainer, &$rc) {
				$rc = $pdoStm->execute();
				$rowsAffected = $pdoStm->rowCount();
				$result = new DBRowsAffectedResult($rowsAffected);
				$resultContainer->add($result);
			}, function () {
			});
		}
		else if ( ($stm instanceof SQLStatementUpdate)
		|| ($stm instanceof SQLStatementInsert)) {

			$rc = null;

			/** @var PDOStatement $pdoStm */
			$pdoStm = null;
			$this->repeatWhenLocked(
				function () use (&$pdoStm, &$rc, $stm) {
					$pdoStm = $this->_preparePdoStatement($stm);
					$rc = $pdoStm->execute();
				},
				function () use (&$pdoStm) {
					$this->getLogger()->warning('exception. ' . @$pdoStm->queryString);
					$this->resetLastPdoStm();
				});

			$rowsAffected = $pdoStm->rowCount();
			$pdoStm->closeCursor();

			$result = new DBRowsAffectedResult();
			$result->rowsAffected = $rowsAffected;
			$resultContainer->add($result);
		}
		else {
			throw new DatabaseException("Don't know how to execute  $class");
		}
		return $rc;
	}


	/**
	 * @param $pdoStm
	 * @return array
	 * @throws DatabaseException
	 */
	public function doExecuteStm(SQLStatement $stm)
	{

	}

	private function resetLastPdoStm()
	{
		$this->getLogger()->warning('reset last sql:' . $this->lastSql);
		unset($this->preparedStm[$this->lastSql]);
	}

	var $lastSql;

	public function _preparePdoStatement(SQLStatement $stm) :PDOStatement
	{
		$generator = $this->getGenerator();
		$query = $generator->generateParametrizedQuery($stm);

		//file_put_contents('/tmp/query', var_export($query, true));
		$sql = $query->getQuery();

		if ($this->signShowQueries) {
			print_r($query);
		}
		if ($this->signDebugQueries) {
			$this->getLogger()->debug($query->toString());
		}
		if (!isset($this->preparedStm[$sql])) {
			try {
				$pdoStm = $this->link->prepare($sql . ";");
			} catch (PDOException $e) {
				$text = $e->getMessage() . "\n\n sql: $sql";
				throw new DatabaseException($text, 0, $e);
			}
			$this->lastSql = $sql;
			$this->preparedStm[$sql] = $pdoStm;
		} else {
			$this->lastSql = $sql;
			$pdoStm = $this->preparedStm[$sql];
		}

		if (!$pdoStm) {
			throw new DatabaseException("Can't prepare statement: $sql\nError: "
				. $this->getEngineError()
				. 'STM: ' . Diagnostics::dumpVar($stm));
		}
		foreach ($query->getParameters() as $param) {

			$rc = $pdoStm->bindValue($param->name, $param->value, $this->_getPdoType($param->type));

			if ($rc === false) {
				throw new DatabaseException("Can't bind value to statement: $sql\nError: " . $this->getEngineError());
			}
		}
		return $pdoStm;
	}

	/**
	 * Get PDO type from Temis.ADO type
	 *
	 * @param string $sqlType Temis.ADO type
	 * @access private
	 */
	protected function _getPdoType(int $sqlType)
	{
		$map = array(
			DBParamType::Integer => PDO::PARAM_INT,
			DBParamType::String => PDO::PARAM_STR,
			DBParamType::Lob => PDO::PARAM_LOB,
			DBParamType::Bool => PDO::PARAM_INT,
			DBParamType::Null => PDO::PARAM_NULL,
			DBParamType::Real => PDO::PARAM_STR
		);

		if (!array_key_exists($sqlType, $map)) return PDO::PARAM_STR;
		return $map[$sqlType];
	}

	/**
	 * Gets last intsert ID.
	 * @return integer
	 * @access public
	 */
	public function lastID(): int
	{
		assert($this->link != null);
		return intval($this->link->lastInsertId());
	}

	public function inTransaction()
	{
		return $this->link->inTransaction();
	}

	private float $transactionStartTime;

	public function beginTransaction()
	{
		if ($this->transactionLevel == 0) {
			$this->transactionStartTime = microtime(true);
			$this->repeatWhenLocked(function () {
				$this->link->beginTransaction();
			}, function () {
			});
		}
		$this->transactionLevel++;

	}

	/**
	 * @throws Exception
	 */
	public function commitTransaction()
	{
		$this->transactionLevel--;
		if ($this->transactionLevel != 0) return;

		$this->repeatWhenLocked(function () {
			$this->link->commit();
		}, function () {
		});
		$this->getLogger()->notice("Transaction time: " . (microtime(true) - $this->transactionStartTime));
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
		for ($tries = 0; $tries < 5; ++$tries) {
			try {
				$method();
			} catch (\PDOException $e) {
				$this->getLogger()->warning("PDO exception:" . $e->getMessage());
				if ($e->getCode() == "HY000" && strstr($e->getMessage(), "locked") !== false) {
					$this->getLogger()->warning("locked $tries. sleep...");
					$whenLocked();
					sleep(1);
					continue;
				}
				throw new DatabaseException($e);
			} catch (\Exception $e) {
				if ($e->getCode() == "HY000" && strstr($e->getMessage(), "locked") !== false) {
					$this->getLogger()->warning("locked $tries. sleep...");
					$whenLocked();
					sleep(1);
					continue;
				}
				throw new DatabaseBusyException($e);
			}
			return;
		}
		$this->getLogger()->warning("Database locked $tries tries. Fire timeout exception");
		throw new DatabaseBusyException("locked");
	}
}


