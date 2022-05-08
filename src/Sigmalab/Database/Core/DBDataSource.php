<?php

namespace Sigmalab\Database\Core;

use Exception;
use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementChange;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementSelectResult;
use Sigmalab\Database\Sql\SQLStatementUpdate;


// error codes
define("DS_SUCCESS", 0);
define("DS_ERROR", 1);
define("DS_CANT_CONNECT", 2);
define("DS_CANT_SELECT_DB", 3);
define("DS_METHOD_DOESNT_SUPPORTED", 4);
define("DS_MSG_NOLINK", "Link is not actived");


define( "SUPPRESS_ERROR_NONE", 0 );
define( "SUPPRESS_ERROR_SINGLE", 1 );
define( "SUPPRESS_ERROR_PERSISTENT", 2 );


/**
 * Base abstract  class for SQL data source implementation .
 * have support for executing statements.
 *
 */
abstract class DBDataSource extends IDataSource
{
	public ?string $lastError = null;
	public int  $signSuppressError = 0;
	public bool $signDebugQueries = false;
	public bool $signShowQueries = false;

	/**
	 * @param bool $signDebugQueries
	 */
	public function setSignDebugQueries(bool $signDebugQueries): void
	{
		$this->signDebugQueries = $signDebugQueries;
	}

	/**
	 * @param bool $signShowQueries
	 */
	public function setSignShowQueries(bool $signShowQueries): void
	{
		$this->signShowQueries = $signShowQueries;
	}


	/**
	 * Connect string, data source name (DSN)
	 *
	 * @var string
	 */
	public string $connectString = "";


	/**
	 * Register connect string for using in messages.
	 * @access protected
	 * @param string $connectString DSN (Data source name)
	 */
	public function setConnectString($connectString)
	{
		$this->connectString = $connectString;
	}


	/**
	 * Execute SQL statement
	 *
	 * @param SQLStatement $stm
	 * @param DBResultContainer|null $resultContainer container strategy
	 * @return int zero on success
	 * @throws Exception
	 * @throws DatabaseException
	 * @throws DatabaseBusyException
	 * @see SQLStatementSelectResult
	 * @see SQLStatementSelect::createResultContainer()
	 * @see DBResultContainer
	 */
	public function queryStatement(SQLStatement $stm, ?DBResultContainer $resultContainer = null)
	{
		$generator = $this->getGenerator();

		if ($stm->isDebug) {
			$this->getLogger()->debug("from {$stm->isDebug}");
			$this->getLogger()->debug($generator->generate($stm));
		}

		//$query = $generator->generate($stm);
		$this->resetError();

		if (!$this->isLinkAvailable()) {
			$this->registerError("", DS_MSG_NOLINK);
			return DS_ERROR;
		}

		if (!$resultContainer) {
			if ($stm instanceof SQLStatementSelect) {
				$resultContainer = $stm->createResultContainer();
			} else if ($stm instanceof SQLStatementChange) {
				$resultContainer = $stm->createResultContainer();
			}
		}

		$resultContainer->begin();
		$rc = $this->_executeStatement($stm, $resultContainer);
		$resultContainer->end();

		return $rc;
	}

	/**
	 * Execute statement.
	 *
	 * This method can be overriden in inherit class for special procesing statements.
	 *
	 * @access protected.
	 * @param SQLStatement $stm
	 * @param DBResultContainer $resultContainer
	 * @return int
	 * @throws Exception
	 */
	protected function _executeStatement(SQLStatement $stm, DBResultContainer $resultContainer)
	{
		$generator = $this->getGenerator();

		if ($stm instanceof SQLStatementSelect) {
			$rc = $this->querySelectEx($generator->generate($stm), $resultContainer);
		} else if ($stm instanceof SQLStatementInsert) {
			$rc = $this->queryCommand($generator->generate($stm), $resultContainer);
			//save pk value
			$stm->object->set_primary_key_value($this->lastID());
		} else if (($stm instanceof SQLStatementUpdate)
			|| ($stm instanceof SQLStatementDelete)) {
			$rc = $this->queryCommand($generator->generate($stm), $resultContainer);
		} else {
			throw new Exception("Don't know how to execute  " . get_class($stm));
		}
		return $rc;
	}

	/**
	 * set suppression errors mode.
	 *
	 * @param bool $sign
	 */
	public function suppressError(bool $sign = true)
	{
		$this->signSuppressError = $sign;
	}

	/**
	 * Reset last error.
	 * @access private
	 */
	public function resetError()
	{
		$this->lastError = null;
	}

	/**
	 * register error caused in query execution.
	 *
	 * @access protected
	 * @param string $query SQL query
	 * @param string|null $appError error string
	 */
	public function registerError(string $query, ?string $appError = null):void
	{
		$logger = $this->getLogger();

		if ($appError) $this->lastError = $appError;
		else $this->lastError = $this->getEngineError();

		if ($this->signDebugQueries) {
			$logger->warning($this->getEngineName() . " Error: {$this->lastError}");
		}
		if ($this->signSuppressError) {
			if (($this->signSuppressError === SUPPRESS_ERROR_SINGLE) || ($this->signSuppressError === 1)) {
				$this->signSuppressError = 0;
			}
			return;
		}
		if (!$appError) {
			$logger->warning("in query: $query <br>\n{$this->getEngineName()} Error: $this->lastError");
		}
	}

	/**
	 * Register error about method not supported.
	 * @param string $scheme scheme(protocol)  name
	 * @return int  data source error code
	 * @access protected
	 */
	public function errorMethodNotSupported(string $scheme)
	{
		$this->registerError("", "Method '{$scheme}'' does not supported");
		return (DS_METHOD_DOESNT_SUPPORTED);
	}

	/**
	 * Retrieve eroror message or code from DB engine (mysql/...)
	 * @return string error message
	 * @access protected
	 */
	public abstract function getEngineError();

	/**
	 * Gets DB engine name.
	 * @return string engine name (mysql, or sqlite..)
	 * @access protected
	 */
	public abstract function getEngineName();

	/**
	 * Gets links available status
	 * @return bool TRUE if Engine link is available , else FALSE
	 * @access protected
	 *
	 */
	public abstract function isLinkAvailable();

	/**
	 * Gets SQLGenerator according to implemented SQL engine.
	 * @return SQLGenerator
	 * @access protected
	 */
	public abstract function getGenerator();

	/**
	 * Gets logger object.
	 * @return DataSourceLogger  logger instance
	 * @access protected
	 */
	public abstract function getLogger();

	/** query "SELECT" to container
	 * @param string $query SQL query
	 * @param DBResultContainer $resultContainer
	 * @return int zero on success
	 * @see DBResultContainer
	 * @see DBDefaultResultContainer
	 * @access public
	 */
	public abstract function querySelect(string $query, DBResultContainer $resultContainer): int;

	/** query "INSERT/UPDATE/DELETE"
	 * @param string $query SQL query
	 * @param DBResultContainer $resultContainer - contaner stategy. method must returns count for affected rows as result set
	 * @return int   0 on success or error code
	 * @access public
	 */
	public abstract function queryCommand(string $query, DBResultContainer $resultContainer);


	/**
	 * Gets last intsert ID.
	 * @return int
	 * @access public
	 */
	public abstract function lastID(): int;

	/**
	 * @param callable():void  $method
	 * @throws DatabaseException
	 */
	public function runInTransaction(callable $method): void
	{
		if ($this->inTransaction()) {
			throw new DatabaseException("Invalid use. Cant rollback on error");
		}
		try {
			$this->beginTransaction();
			$method();
			$this->commitTransaction();
		} catch (Exception $e) {
			$this->rollbackTransaction();
			throw $e;
		}
	}


	/**
	 * @param string $query
	 * @param DBResultContainer $resultContainer
	 * @return int
	 * @throws DatabaseException
	 */
	abstract public function querySelectEx(string $query, DBResultContainer $resultContainer): int;

	public function destruct(): void
	{
	}

}
