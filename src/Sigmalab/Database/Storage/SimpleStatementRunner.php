<?php

namespace Sigmalab\Database\Storage;

use Sigmalab\Database\Core\DBDefaultResultContainer;
use Sigmalab\Database\Core\DBInsertOneResult;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Core\IDataSource;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementChange;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;

/**
 * Class SimpleStatementRunner provides simple strategy to executing SQL statements.
 */
class SimpleStatementRunner implements IStatementRunner
{
	private IDataSource $connection;

	public function __construct(IDataSource $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Execute statement and return result as return value.
	 *
	 * @param SQLStatement $stm Statement.
	 * @return IDataObject[]  result set of objects or last ID.
	 * @throws \Sigmalab\Database\DatabaseException
	 */
	public function execute(SQLStatement $stm): array
	{
		if (!$stm) {
			return array();
		}
		if ( $stm instanceof SQLStatementSelect ) {
			$container = instance_cast($stm->createResultContainer(true), DBResultContainer::class);
		}
		else if ( $stm instanceof SQLStatementChange){
			$container = $stm->createResultContainer();
		}
		else {
			$container= new DBDefaultResultContainer($stm->object, false);
		}
		$this->connection->queryStatement($stm, $container);

		$lastID = -1;
		if ($stm instanceof SQLStatementInsert) {
			$lastID = $this->connection->lastID();
			$stm->object->set_primary_key_value( $lastID );
		}
		if ($lastID != -1) {
			return [new DBInsertOneResult($lastID)];
		}
		return $container->getResult();
	}

	/**
	 * Execute select statement and return only first value.
	 *
	 * @param SQLStatementSelect $stm select statement
	 * @return IDataObject
	 */
	public function executeSelectOne(SQLStatementSelect $stm):?IDataObject
	{
		$objs = $this->execute($stm);
		return array_shift($objs);
	}
}