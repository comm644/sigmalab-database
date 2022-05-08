<?php
/**
 * @noinspection KphpDocInspection
 * @noinspection KphpUndefinedClassInspection
 * @noinspection PhpUndefinedClassInspection
 * @noinspection PhpMultipleClassesDeclarationsInOneFile
 */
declare(strict_types=1);

namespace Sigmalab\DatabaseEngine\Sqlite;

use DSN;
use Exception;
use Sigmalab\Database\Core\DataSourceLogger;
use Sigmalab\Database\Core\DBDataSource;
use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\DBRowsAffectedResult;
use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementChange;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use SQLite3;

require_once __DIR__ . '/../../../../../uuid/uuid.php';
require_once(__DIR__ . "/../../../../DSN.php");

class TypeCodes
{
	public const SQLITE3_INTEGER = 1;
	public const SQLITE3_FLOAT = 2;
	public const SQLITE3_BLOB = 4;
	public const SQLITE3_NULL = 5;
	public const SQLITE3_TEXT = 3;
}

class SqliteOpenMode
{
	public const SQLITE3_OPEN_READWRITE = 0x00000002;
	public const SQLITE3_OPEN_CREATE = 0x00000004;
}

class FfiSqliteDataSource extends DBDataSource
{
	/// use DBTransactionControl; //-----------------------------------------
	private int $transactionLevel = 0;
	private float $transactionStartTime = 0;
	private string $uid = "";

	public function inTransaction(): bool
	{
		return $this->transactionLevel > 0;
	}


	/**
	 * @throws DatabaseBusyException
	 * @throws DatabaseException
	 */
	public function beginTransaction()
	{
		if ($this->transactionLevel === 0) {
			$this->transactionStartTime = (float)microtime(true);
			$this->linkBeginTransaction();;
		}
		$this->transactionLevel++;
	}

	/**
	 * @throws \Exception
	 */
	public function commitTransaction()
	{
		if ($this->transactionLevel < 0) return;

		$this->transactionLevel--;
		if ($this->transactionLevel !== 0) return;

		$this->linkCommitTransaction();
		$this->getLogger()->notice("Transaction time: " . (microtime(true) - $this->transactionStartTime));
	}

	public function rollbackTransaction()
	{
		$this->linkRollbackTransaction();;
		$this->transactionLevel = 0;
	}

	///--------------------------------------------------

	private const SQLITE_LOWALPHA = "абвгдеёжзийклмнорпстуфхцчшщъьыэюя";
	private const SQLITE_HIALPHA = "АБВГДЕЁЖЗИЙКЛМНОРПСТУФХЦЧШЩЪЬЫЭЮЯ";


	protected $link = null;

	/** @var ffi_cdata<sqlite3, struct sqlite3_stmt*>[] */
	protected array $preparedStm = [];

	private ?SQLStatement $lastStm = null;
	private bool $isUseSafeStrings = false;
	private $ffi;
	/** @var ffi_scope<sqlite3> */
	private $lib;

	public function __construct()
	{
		/** @noinspection KphpAssignmentTypeMismatchInspection */
		$this->preparedStm = array();
		$this->uid = uuid();
	}

#ifndef KPHP
	public function __destruct()
	{
		$this->destruct();
	}
#endif

	public function getEngineName()
	{
		return ("Sqlite3");
	}

	/**
	 * connect to database
	 *
	 * @param string $connectonUrl such as: "sqlite://localhost//?database=path/to/database.db"
	 * @return int  DS_SUCCESS or error
	 */
	public function connect(string $connectonUrl)
	{

		$logger = $this->getLogger();
		$logger->debug("connecting to $connectonUrl");
		$this->setConnectString($connectonUrl);

		$dsn = new DSN($connectonUrl);
		$method = $dsn->getMethod();
		if ($method !== "sqlite") {
			return $this->errorMethodNotSupported((string)$method);
		}

		$file = $dsn->getDatabase();

		// Connecting, selecting database
		$this->link = null;
		/** @noinspection KphpAssignmentTypeMismatchInspection */
		$this->preparedStm = array();

		$this->ffi = \FFI::load(__DIR__ . '/sqlite3-ffi.h');
		$this->lib = \FFI::scope("sqlite3");

		$this->link = $this->lib->new("struct sqlite3*");
		//		$rc = $this->lib->sqlite3_open_v2($file, \FFI::addr($this->link),
//			SqiteOpenMode::SQLITE3_OPEN_CREATE | SqiteOpenMode::SQLITE3_OPEN_READWRITE, "");
		$rc = $this->lib->sqlite3_open((string)$file, \FFI::addr($this->link));
		$logger->debug("open rc=$rc");

		$this->lib->sqlite3_busy_timeout($this->link, 1000);
		$this->driverQuerySingle("PRAGMA journal_mode = MEMORY");

//		$rc = $this->link->createFunction('ru_upper', function ($string) {
//			$string = strtr($string, self::SQLITE_LOWALPHA, self::SQLITE_HIALPHA);
//			$rc = strtoupper($string);
//			return $rc;
//		});
//		if ($rc === false) {
//			$logger->warning("Can't create collation for ru_RU");
//		}
		return (DS_SUCCESS);
	}


	public function getEngineError()
	{
		$rc = $this->driverLastError();
		if (!$rc) return 'Success.';
		return $this->driverLastErrorMessage();
	}

	/**
	 * Gets last intsert ID.
	 * @return int
	 * @access public
	 */
	public function lastID(): int
	{
//		assert($this->lib !== null);
//		assert($this->link !== null);
		return (int)$this->lib->sqlite3_last_insert_rowid($this->link);
	}

	/** Gets count of changes
	 * @return int
	 */
	private function driverGetAffectedRowsCount(): int
	{
//		assert($this->lib !== null);
//		assert($this->link !== null);
		return (int)$this->lib->sqlite3_changes($this->link);
	}

	private function driverQuerySingle(string $sql): int
	{
		$msg = $this->lib->new("char*");


		$driverStm = $this->driverPrepareStm($sql);
		$this->driverExecuteStep($driverStm);
		$this->driveFinalizeStm($driverStm);;

		$rc = $this->lib->sqlite3_errcode($this->link);
		$this->lib->sqlite3_free($msg);

		//FIXME: throw exception on error.
		return $rc;
	}

	public function isLinkAvailable()
	{
		return $this->link !== null;
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

	/**
	 * @param ffi_cdata<sqlite3, struct sqlite3_stmt*> $driverStm
	 * @param DBResultContainer $resultContainer
	 * @param string $query
	 * @throws DatabaseException
	 * @noinspection KphpDocInspection
	 * @noinspection NoTypeDeclarationInspection
	 */
	protected function _processSelectResult($driverStm, DBResultContainer $resultContainer, string $query): void
	{
//		if (!$driverStm) {
//			throw new DatabaseException("Query error: {$this->getEngineError()}\nQuery: $query ");
//		}
		$count = 0;
		while (true) {

			$rc = $this->lib->sqlite3_step($driverStm);
			if ($rc !== FfiSqliteCodes::SQLITE_ROW) break;

			$ncols = $this->lib->sqlite3_column_count($driverStm);

			/** mixed $row */
			$row = [];
			for ($i = 0; $i < $ncols; ++$i) {
				$sqValue = $this->lib->sqlite3_column_value($driverStm, $i);

				$type = $this->lib->sqlite3_value_type($sqValue);
				switch ($type) {
					case TypeCodes::SQLITE3_TEXT:
						$cdata = $this->lib->sqlite3_value_text($sqValue);
						$row[] = (string)$cdata;
						break;
					case TypeCodes::SQLITE3_BLOB:
						$cdata = $this->lib->sqlite3_value_text($sqValue);
						$row[] = (string)$cdata;
						break;
					case TypeCodes::SQLITE3_INTEGER:
						$row[] = (int)$this->lib->sqlite3_value_int64($sqValue);
						break;
					case TypeCodes::SQLITE3_NULL:
						$row[] = null;
						break;
					case TypeCodes::SQLITE3_FLOAT:
						$row[] = (string)$this->lib->sqlite3_value_blob($sqValue);
						break;
					default:
						$row[] = null;
				}
			}
			$obj = $resultContainer->fromSQL($row);
			$resultContainer->add($obj);
			++$count;
		}
		if ($this->signDebugQueries) {
			$this->getLogger()->debug("select result: $count items");
		}
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
	 * @param DBResultContainer $resultContainer container strategy. method must returns count for affected rows as result set
	 * @return int  0 on success or error code
	 * @throws DatabaseBusyException
	 * @throws Exception
	 */
	public function queryCommand(string $query, DBResultContainer $resultContainer)
	{
		try {
			$this->getLogger()->debug("{$query} link:" . $this->uid);
			$this->driverQuerySingle($query . ";");
			$resultContainer->add(new DBRowsAffectedResult((int)$this->driverGetAffectedRowsCount()));
		} catch (Exception $e) {
			if ($e->getCode() === 5) {
				$this->getLogger()->warning("locked...");
				throw new DatabaseBusyException($e->getMessage());
			}

			$this->getLogger()->error($query);
			throw $e;
		}

		return 0;
	}

	public function querySelect(string $query, DBResultContainer $resultContainer): int
	{
		try {
//			$this->getLogger()->debug("{$query} link:".$this->uid);
			$driverStm = $this->driverPrepareStm($query);
		} catch (Exception $e) {
			echo "Error in statement: $query:" . $e->getMessage();
			$driverStm = null;
		}
		//if  (!$driverStm) return -1;
		$this->_processSelectResult($driverStm, $resultContainer, $query);
		$rc = $this->driverLastError();
		$this->driveFinalizeStm($driverStm);
		return $rc;
	}


	protected function _executeStatement(SQLStatement $stm, DBResultContainer $resultContainer)
	{
		//process query
		//$rc = false;
		$generator = $this->getGenerator();

		$class = get_class($stm);
		$driverResult = 0;
		if ($stm instanceof SQLStatementSelect) {
			try {
				/** @var ffi_cdata<sqlite3, struct sqlite3_stmt*> $driverStm */
				$driverStm = $this->_prepareStatement($stm);
				$this->_processSelectResult($driverStm, $resultContainer, "SQL query");
				$driverResult = $this->driverLastError();
			} catch (Exception $e) {
				$message = $this->getStmErrorMessage($stm, $e);
//				if (php_sapi_name() == "cli") {
//					print_r($message);
//				}
				throw new DatabaseException($message);
			}
		} else if ($stm instanceof SQLStatementDelete) {

			$sql = $generator->generate($stm);
			try {
				$this->driverQuerySingle($sql);
			} catch (Exception $e) {
				throw new DatabaseException("Can't prepare statement: $sql\nError: " . $e->getMessage());
			}

			$resultContainer->add(new DBRowsAffectedResult($this->driverGetAffectedRowsCount()));

		} else if (($stm instanceof SQLStatementUpdate)
			|| ($stm instanceof SQLStatementInsert)) {

			/** @var SQLStatementChange $stmUpdate */
			$stmUpdate = instance_cast($stm, SQLStatementChange::class);
			$driverResult = 0;

			/** @var ffi_cdata<sqlite3, struct sqlite3_stmt*> $driverStm */
			$this->repeatWhenLocked(
				function () use ($stm, $resultContainer) {

					if ($this->signDebugQueries) {
						$class = get_class($stm->object);
						$this->getLogger()->notice("{$stm->sqlStatement} {$stm->table} ({$class}) link:" . $this->uid);
					}

					$driverStm = $this->_prepareStatement($stm);
					$this->driverExecuteStep($driverStm);
					//not need fetch result it causes executing query twice.
					$resultContainer->add(new DBRowsAffectedResult($this->driverGetAffectedRowsCount()));
				},
				function () use ($stm, $stmUpdate) {
					$this->getLogger()->warning('exception. ' . $stmUpdate->generate($this->getGenerator()));
					$this->resetLastPdoStm();
				});
			if ($stm instanceof SQLStatementInsert) {
				$driverResult = $this->lastID();
			}
		} else {
			throw new DatabaseException("Don't know how to execute  $class");
		}
		return (int)$driverResult;
	}


	private function resetLastPdoStm(): void
	{
		$this->getLogger()->warning('reset last sql:' . $this->lastSql);
		unset($this->preparedStm[$this->lastSql]);
	}

	public string $lastSql = '';

	/**
	 * @param SQLStatement $stm
	 * @return ffi_cdata<sqlite3, struct sqlite3_stmt*>
	 * @throws DatabaseException
	 */
	public function _prepareStatement(SQLStatement $stm)
	{
		$generator = $this->getGenerator();
		$query = $generator->generateParametrizedQuery($stm);
		$sql = $query->getQuery();

		if ($this->signShowQueries) {
			/** @noinspection ForgottenDebugOutputInspection */
			print_r($query);
		}
		if ($this->signDebugQueries) {
			$this->getLogger()->debug($query->toString());
		}

		$this->lastStm = $stm;
		$this->lastSql = $sql;

		if (!isset($this->preparedStm[$sql])) {
			$driverStm = $this->driverPrepareStm($sql);
			/** @noinspection KphpAssignmentTypeMismatchInspection */
			$this->preparedStm[$sql] = $driverStm;
		} else {
			$driverStm = $this->preparedStm[$sql];
			$this->lib->sqlite3_reset($driverStm);
			$this->lib->sqlite3_clear_bindings($driverStm);
		}

		foreach ($query->getParameters() as $param) {
			$type = $param->type;
			$value = $param->value;
			if ($this->isUseSafeStrings) {
				if ($type === DBParamType::String) {
					if (strpos((string)$value, "\0") !== false) {
						$type = TypeCodes::SQLITE3_BLOB;
					}
				}
			}

			$idx = $this->lib->sqlite3_bind_parameter_index($driverStm, $param->name);
			switch ($type) {
				case DBParamType::String:
					$this->lib->sqlite3_bind_text($driverStm, $idx, (string)$value, strlen($value), 0);
					break;
				case DBParamType::Lob:
					$this->lib->sqlite3_bind_blob($driverStm, $idx, (string)$value, strlen($value), 0);
					break;
				case DBParamType::Integer:
					$this->lib->sqlite3_bind_int($driverStm, $idx, (int)$value);
					break;
				case DBParamType::Null:
					$this->lib->sqlite3_bind_null($driverStm, $idx);
					break;
				case DBParamType::Real:
					$this->lib->sqlite3_bind_double($driverStm, $idx, (float)$value);
					break;
				default:
					throw new DatabaseException("Can't bind value to statement: $sql\n Unknown type");
			}
		}
		return $driverStm;
	}

	/**
	 * Get Sqlite3 type from Temis.ADO type
	 *
	 * @param string $sqlType Temis.ADO type
	 * @access private
	 * @return int
	 */
	protected function _getType($sqlType)
	{
		/** @var int[] $map */
		$map = array(
			DBParamType::Integer => TypeCodes::SQLITE3_INTEGER,
			DBParamType::String => TypeCodes::SQLITE3_TEXT,
			DBParamType::Lob => TypeCodes::SQLITE3_BLOB,
			DBParamType::Bool => TypeCodes::SQLITE3_INTEGER,
			DBParamType::Null => TypeCodes::SQLITE3_NULL,
			DBParamType::Real => TypeCodes::SQLITE3_FLOAT
		);

		if (!array_key_exists($sqlType, $map)) return TypeCodes::SQLITE3_TEXT;
		return $map[$sqlType];
	}

	/** Run method and process locked database state
	 *
	 * @param callable():void $method target method
	 * @param callable():void $whenLocked method which need to call when database locked, for retry
	 * @throws Exception
	 * @throws DatabaseBusyException
	 * @throws DatabaseException
	 */
	public function repeatWhenLocked(callable $method, callable $whenLocked)
	{
		for ($attempt = 0; $attempt < 5; ++$attempt) {
			try {
				$method();
				return;
			} catch (Exception $e) {
				$lastError = $this->driverLastError();
				if ($lastError === 5) {
					$this->getLogger()->warning("locked $attempt. sleep...");
					$whenLocked();
					sleep(1);
					continue;
				}
				$msg = $this->driverLastErrorMessage();
				$this->getLogger()->warning("Database exception: code={$lastError} msg={$msg}");
				$message = $this->getStmErrorMessage($this->lastStm, $e);
				throw new DatabaseException($message);
			}
		}

		$this->getLogger()->warning("Database locked $attempt tries. Fire timeout exception");
		throw new DatabaseBusyException("Database locked");
	}

	/**
	 * @param SQLStatement $stm
	 * @param Exception $e
	 * @return string
	 * @throws Exception
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

	/**
	 * @throws DatabaseBusyException
	 * @throws DatabaseException
	 */
	protected function linkCommitTransaction(): void
	{
		$this->getLogger()->debug("commit link:" . $this->uid);
		$this->repeatWhenLocked(function () {
			$this->driverQuerySingle("COMMIT;");
		}, function () {
		});
	}

	protected function linkRollbackTransaction(): void
	{
		$this->getLogger()->debug("link:" . $this->uid);
		if ($this->inTransaction()) {
			$this->driverQuerySingle("ROLLBACK TRANSACTION;");
		}
	}

	/**
	 * @throws DatabaseBusyException
	 * @throws DatabaseException
	 */
	protected function linkBeginTransaction(): void
	{
		$this->getLogger()->debug("begin link:" . $this->uid);
		$this->repeatWhenLocked(function () {
			$this->driverQuerySingle("BEGIN TRANSACTION;");
		}, function () {
		});
	}

	private function driverLastError(): int
	{
		return (int)$this->lib->sqlite3_errcode($this->link);
	}

	private function driverLastErrorMessage(): string
	{
		return (string)$this->lib->sqlite3_errmsg($this->link);
	}

	/**
	 * @param ffi_cdata<sqlite3, struct sqlite3_stmt*> $driverStm
	 * @throws Exception
	 * @noinspection NoTypeDeclarationInspection
	 */
	private function driverExecuteStep($driverStm):int
	{
		return (int)$this->lib->sqlite3_step($driverStm);
	}

	/**
	 * @param string $sql
	 * @return ffi_cdata<sqlite3, struct sqlite3_stmt*>
	 */
	private function driverPrepareStm(string $sql)
	{
		/** @var ffi_cdata<sqlite3, struct sqlite3_stmt*> $driverStm */
		$driverStm = $this->lib->new("struct sqlite3_stmt *");
		$szTail = $this->lib->new("char*");
		$tail = "";
		$rc = $this->lib->sqlite3_prepare($this->link, $sql, strlen($sql) + 1, \FFI::addr($driverStm), \FFI::addr($szTail));
		if ($rc) {
			throw new Exception("Sqlite error: $rc :" . $this->driverLastErrorMessage());
		}
		return $driverStm;
	}

	/**
	 * @param $driverStm
	 * @noinspection NoTypeDeclarationInspection
	 */
	private function driveFinalizeStm($driverStm): void
	{
		$this->lib->sqlite3_finalize($driverStm);
	}

	public function destruct(): void
	{
		if ($this->link !== null) {
			if ($this->inTransaction()) {
				$this->getLogger()->debug("commit on destroy");
				try {
					$this->linkCommitTransaction();
				} catch (Exception $e) {
				}
			}
			foreach ($this->preparedStm as $driverStm) {
				$this->driveFinalizeStm($driverStm);
			}

			$this->lib->sqlite3_close($this->link);
		}
		$this->link = null;
	}

}


