<?php

namespace Sigmalab\Database\Core;
use Sigmalab\Database\Sql\SQLStatement;

/**
 *
 * \brief object oriented data source access interface
 *
 * This interface provides object oriented access to data-sources and
 * performs executing SQLStatements only without direct queries
 */
abstract class IDataSource
{

	/** method performs connecting to data base
	 * @param string $dsn \b string describes Data Source Name  as next string:
	 * engine_name://username:password@server[:port]/database
	 * @return int error code as \b enum specified for concrete data source
	 */
	public abstract function connect(string $dsn);

	/** execute SQLstatement
	 * @param SQLStatement $statement object
	 * @param DBResultContainer|null $resultContainer
	 * @return int success code
	 */
	public abstract function queryStatement(SQLStatement $statement, ?DBResultContainer $resultContainer = null);

	public function beginTransaction()
	{
	}

	public function commitTransaction()
	{
	}

	public function inTransaction()
	{
		return false;
	}

	public function rollbackTransaction()
	{
	}

	/**
	 * Gets last inserted ID.
	 * @return int
	 */
	public abstract function lastID(): int;
}

