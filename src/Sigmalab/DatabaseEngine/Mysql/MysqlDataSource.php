<?php /** @noinspection PhpUndefinedFunctionInspection */

namespace Sigmalab\DatabaseEngine\Mysql;

/******************************************************************************
 Module : database proxy
 File :   DataSource.php
 Author : Alexei V. Vasilyev
 -----------------------------------------------------------------------------
 Description:
******************************************************************************/

use Sigmalab\Database\Core\DataSourceLogger;
use Sigmalab\Database\Core\DBCommandContainer;
use Sigmalab\Database\Core\DBDataSource;
use Sigmalab\Database\Core\DBDefaultResultContainer;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementSelectResult;
use Sigmalab\Database\Sql\SQLStatementUpdate;

require_once(__ADO_PHP_DIR__ . "/DSN.php");


if (!defined( 'DS_MSG_NOLINK')) {
	define( "DS_MSG_NOLINK", "Link is not actived" );
}


//define( "DIR_SQLCACHE", __DIR__ . "/../sql.cache/" );

class MysqlDataSource extends DBDataSource
{
	public $link = null;
	public string $timefunc = "time";

	public bool $signUseCache = false;
	public bool $signUseNames = true;
	public bool $signDualAccess = false;  //sign about dual access to single server


	/**
	 * connect to database
	 *
	 * @param string $dsn
	 * @return int  DS_SUCCESS or error
	 */
	public function connect(string $dsn)
	{
		$this->connectString = $dsn;

		$dsn = new \DSN($dsn);
		if ($dsn->getMethod() != "mysql") {
			return $this->errorMethodNotSupported($dsn->getMethod());
		}

		// Connecting, selecting database
		$port = ($dsn->getPort() !== "") ? (":" . $dsn->getPort()) : "";
		$this->link = @mysql_connect($dsn->getHost() . $port, $dsn->getUsername(), $dsn->getPassword());
		if (!$this->link) {
			$this->registerError("", "Can't connect to '{$dsn->getHost()}' as '{$dsn->getUsername()}'" . '(' . mysql_error() . ')');
			return (DS_CANT_CONNECT);
		}

		$this->registerHost($dsn->getHost() . $dsn->getPort() . $dsn->getDatabase(), $dsn->getTable());
		//echo 'Connected successfully';
		$this->database = $dsn->getDatabase();
		$rc = $this->selectDatabase();
		if ($rc) return ($rc);

		$rc = $this->setPacketSize();
		if ($rc) return ($rc);

		$this->setEncoding();
		DataSourceLogger::notice("encoding:" . mysql_client_encoding($this->link));
		return (DS_SUCCESS);
	}

	public function selectDatabase()
	{
		$rc = @mysql_select_db($this->database, $this->link);
		if (!$rc) {
			$this->registerError("", "Can't Select database '{$this->database}': " . mysql_error());
			return (DS_CANT_SELECT_DB);
		}
		return (DS_SUCCESS);
	}

	/**
	 * Set packet size for accepting big blobs
	 *
	 * @return int
	 */
	public function setPacketSize()
	{
		$container = new DBCommandContainer();
		$rc = $this->queryCommand("SET max_allowed_packet=50000000", $container);
		return DS_SUCCESS;
	}

	public function setEncoding()
	{
		if (!$this->signUseNames) return;
		$saved = array($this->signSuppressError, $this->signDebugQueries);
		$this->signSuppressError = 1;
		$this->signDebugQueries = false;
		$container = new DBCommandContainer();
		$rc = $this->queryCommand("SET NAMES 'utf8'", $container);

		list($this->signSuppressError, $this->signDebugQueries) = $saved;
		if ($rc) {

			$this->signUseNames = false;
		}
	}

	/**
	 * Returns last error.
	 *
	 * @return string
	 */
	public function lastError()
	{
		return ($this->lastError);
	}

	/**
	 * Disconnect from current datasource
	 *
	 * @return int zero on success (always)
	 */
	public function disconnect()
	{
		// Closing connection
		mysql_close($this->link);
		$this->link = null;
		return (0);
	}

	public function suppressError(bool $sign = true)
	{
		$this->signSuppressError = (int)$sign;
	}

	public function resetError()
	{
		$this->lastError = null;
	}


	public function registerError(string $query, ?string $appError = null):void
	{
		if ($appError) $this->lastError = $appError;
		else $this->lastError = mysql_error($this->link);

		if ($this->signDebugQueries) {
			DataSourceLogger::warning("MYSQL Error: {$this->lastError}");
		}
		if ($this->signSuppressError) {
			if (($this->signSuppressError == SUPPRESS_ERROR_SINGLE) || ($this->signSuppressError === true)) {
				$this->signSuppressError = (int)false;
			}
			return;
		}
		if (!$appError) {
			DataSourceLogger::warning("in query: $query <br>\nMYSQL Error: $this->lastError");
		}
	}

	public function querySelect(string $query, DBResultContainer $resultContainer): int
	{
		return $this->querySelectEx($query, $resultContainer);
	}


	/** query "SELECT" to container
	 * @param string $query
	 * @param DBResultContainer $resultContainer
	 * @return int zero on success
	 * @see DBResultcontainer
	 * @see DBDefaultResultContainer
	 */
	public function querySelectEx(string $query, DBResultContainer $resultContainer): int
	{
		$this->resetError();
		$resultContainer->begin();

		if (!$this->link) {
			$this->registerError("", DS_MSG_NOLINK);
			return DS_ERROR;
		}

		if ($this->signShowQueries) print($query . ";\n");
		if ($this->signDebugQueries) DataSourceLogger::debug(str_replace(array("\n", "\r"), array(" ", " "), $query) . ";");
		if ($this->signUseCache) {
			$rc = $this->getFromCache($query, $dataset);
			if (!$rc) return (0);
		}

		//set database
		$this->syncDSN();

		// Performing SQL query
		$result = mysql_query($query, $this->link);
		if ($result == false) {
			$this->registerError($query);
			return (1);
		}

		$nrow = 0;
		while (($line = mysql_fetch_object($result))) {
			$obj = $resultContainer->fromSQL($line);
			$resultContainer->add($obj);
			$nrow++;
		}
		$resultContainer->end();


		if ($this->signDebugQueries) DataSourceLogger::debug("returned {$nrow} rows");

		if ($this->signUseCache) {
			$dataset = $resultContainer->getResult();
			$this->putToCache($query, $dataset);
		}

		// Free resultset
		mysql_free_result($result);
		return (0);
	}


	/**
	 * Execute SQL statement
	 *
	 * $resultcontainer  contaner stategy
	 * @return int zero on success
	 * @see DBResultContainer
	 * @see SQLStatementSelectResult
	 * @see SQLStatementSelect::createResultContainer()
	 * @noinspection PhpDocSignatureInspection
	 */
	public function executeStatement(SQLStatementSelect $stm, DBResultContainer &$resultcontainer)
	{
		$class = get_class($stm);
		if ($stm instanceof SQLStatementSelect) {
			return $this->querySelectEx($stm->generate($this->getGenerator()), $resultcontainer);
		}
		if (($stm instanceof SQLStatementDelete)
			|| ($stm instanceof SQLStatementUpdate)
			|| ($stm instanceof SQLStatementInsert)
		) {
			$rc = $this->queryCommand($stm->generate($this->getGenerator()), $resultcontainer);
			$resultcontainer->begin();
			$resultcontainer->add(mysql_affected_rows());
			$resultcontainer->end();
			return $rc;
		}


		throw new DatabaseException("Don't know how to execute  $class");
	}


	/** query "INSERT/UPDATE/DELETE"
	 * @param string $query
	 * @param DBResultContainer $resultContainer
	 * @return int  0 on success or error code
	 */
	public function queryCommand(string $query, DBResultContainer $resultContainer)
	{
		if (!$this->link) {
			$this->registerError("", DS_MSG_NOLINK);
			return DS_ERROR;
		}
		if ($this->signShowQueries) print($query . ";\n");
		if ($this->signDebugQueries) DataSourceLogger::debug(str_replace(array("\n", "\r"), array(" ", " "), $query) . ";");

		//set database, resource can be modified from other object
		$this->syncDSN();

		// Performing SQL query
		$result = mysql_query($query, $this->link);
		if ($result === false) {
			$this->registerError($query);
			return (true);
		}
		return (0);
	}

	public function lastID(): int
	{
		if (!$this->link) {
			$this->registerError("", DS_MSG_NOLINK);
			return -1;
		}
		return (mysql_insert_id($this->link));
	}

	public function getAffectedRows()
	{
		if (!$this->link) {
			$this->registerError("", DS_MSG_NOLINK);
			return -1;
		}
		return mysql_affected_rows($this->link);
	}

	public function now()
	{
		$timefunc = $this->timefunc;
		return (DataSource::getDateTime($timefunc()));
	}

	public function getDateTime($val)
	{
		return (strftime("%Y-%m-%d %H:%M:%S", $val));
	}


	public static function escapeString($str)
	{
		return (mysql_real_escape_string($str));
	}

	public function getFromCache($query, &$dataset)
	{
		$md5 = md5($query);
		$filename = DIR_SQLCACHE . "/" . $md5;
		if (file_exists($filename)) {
			$dataset = unserialize(file_get_contents($filename));
		} else {
			return (true);
		}
		debug_log(DLOG_USR, "retrieved from cache: " . $filename);
		return (false);
	}

	public function putToCache($query, &$dataset)
	{
		$md5 = md5($query);
		$filename = DIR_SQLCACHE . "/" . $md5;
		file_put_contents($filename, serialize($dataset));
		debug_log(DLOG_USR, "saved to cache: " . $filename);
		return (false);
	}


	public function registerHost($host, $tableName)
	{
		global $DataSourceHosts;
		if (!isset($DataSourceHosts)) {
			$DataSourceHosts = array();
		}

		if (!array_key_exists($host, $DataSourceHosts)) {
			$obj = new stdclass;
			$obj->tableName = $tableName;
			$obj->dualAccess = false;

			$DataSourceHosts[$host] = $obj;
		} else if ($DataSourceHosts[$host]->tableName != $tableName) {
			$DataSourceHosts[$host]->dualAccess = true;
		}
		$this->host = $host;
		$this->signDualAccess = true;
	}

	public function syncDSN()
	{
		if ($this->signDualAccess) {
			$this->selectDatabase();
		}
	}

	public function getErrorString($rc)
	{
		switch ($rc) {
			case DS_SUCCESS:
				return "Success";
			case DS_CANT_CONNECT:
				return "Can't connect";
			case DS_METHOD_DOESNT_SUPPORTED:
				return "Method doesn't supported";
			case DS_CANT_SELECT_DB:
				return "Can't select database";
			default:
				return "Unknown code $rc";
		}
	}

	/**
	 * Gets SQLGenerator according to implemented SQL engine.
	 * @return SQLGenerator
	 * @access protected
	 */
	public function getGenerator()
	{
		return new MysqlGenerator();
	}

	/**
	 * Gets logger intsance
	 * @return DataSourceLogger
	 */
	public function getLogger()
	{
		return DataSourceLogger::getInstance();
	}

	public function isLinkAvailable()
	{
		return $this->link != null;
	}

	/**
	 * Retrieve eroror message or code from DB engine (mysql/...)
	 * @return string error message
	 * @access protected
	 */
	public function getEngineError()
	{
		return mysql_error($this->link);
	}

	/**
	 * Gets DB engine name.
	 * @return string engine name (mysql, or sqlite..)
	 * @access protected
	 */
	public function getEngineName()
	{
		return 'mysql';
	}
};
