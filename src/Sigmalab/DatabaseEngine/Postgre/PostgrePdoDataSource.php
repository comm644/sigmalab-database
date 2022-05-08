<?php

namespace Sigmalab\DatabaseEngine\Postgre;

use DSN;
use PDO;
use PDOException;
use PDOStatement;
use Sigmalab\Database\Core\DBDefaultResultContainer;
use Sigmalab\Database\DatabaseException;
use Sigmalab\DatabaseEngine\Sqlite\PdoSqliteDataSource;

require_once __DIR__ . '/../Sqlite/PdoSqliteDataSource.php';
require_once __DIR__ . '/PostgreGenerator.php';

/**
 * Created by PhpStorm.
 * User: comm
 * Date: 13.02.17
 * Time: 1:02
 */
class PostgrePdoDataSource extends PdoSqliteDataSource
{
	public function getEngineName()
	{
		return "PDO(pgsql)";
	}

	public function connect(string $dsn)
	{
		$logger = $this->getLogger();
		$logger->debug("connecting to $dsn");
		$this->setConnectString($dsn);

		$dsn = new DSN($dsn);

		$method = $dsn->getMethod();
		if ($method != "pgsql") {
			return $this->errorMethodNotSupported($method);
		}

		$file = $dsn->getDatabase();

		// Connecting, selecting database
		try {
			$this->link = null;
			$this->preparedStm = array();
			//pgsql:host=localhost;port=5432;dbname=testdb;user=bruce;password=mypass
			$params = array(
				"host" => $dsn->getHost(),
				"port" => $dsn->getPort(),
				"dbname" => $dsn->getDatabase(),
				//"username" => $dsn->getUsername(),
				///"password" => $dsn->getPassword()
			);
			$connectionString = array();;
			foreach ($params as $key => $value) {
				if (!$value) continue;
				$connectionString[] = "$key=$value";
			}
			$connectionString = "pgsql:" . implode(";", $connectionString);
			//echo "\n\n$connectionString\n\n";

			$this->link = new PDO($connectionString, $dsn->getUsername(), $dsn->getPassword());
//			$this->link = new PDO( "sqlite:$file", "", "", array(PDO::ATTR_PERSISTENT => true));
			$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE );
			$this->link->setAttribute(PDO::ATTR_PERSISTENT, false);
			$this->link->setAttribute(PDO::ATTR_TIMEOUT, 1);

		} catch (PDOException $exception) {
			$this->registerError("", "Can't connect to '{$file}':{$exception->getMessage()} ");
			throw new DatabaseException($exception->getMessage() . "$file");
		}

		return (DS_SUCCESS);
	}

	protected function _processSelectResult(PDOStatement $resultStm, &$resultContainer, $query)
	{
		if (!$resultStm) {
			throw new DatabaseException("PDO query error: {$this->getEngineError()}\nQuery: $query ");
		}
		$count = 0;
		foreach ($resultStm->fetchAll(PDO::FETCH_NUM) as $row) {
			/** @var DBDefaultResultContainer $resultContainer */
			$obj = $resultContainer->fromSQL($row);
			foreach ($obj as $key => $value) {
				if (is_resource($value)) {
					$obj->$key = null;
					while (!feof($value)) {
						$obj->$key .= fread($value, 8192);
					}
					fclose($value);
				}
			}

			$resultContainer->add($obj);
			$count++;
		}
		if ($this->signDebugQueries) {
			$this->getLogger()->debug("select result: $count items");
		}

		return 0;
	}

	public function getGenerator()
	{
		return new PostgreGenerator();
	}


	/**
	 * Gets last intsert ID.
	 * @return int
	 * @access public
	 */
	public function lastID(): int
	{
		assert($this->link != null);
		foreach ($this->link->query("SELECT LASTVAL()") as $row) {
			return intval($row["lastval"]);
		};
		throw new DatabaseException("No lastval returned");
		//return intval($this->link->lastInsertId($name));
	}


}