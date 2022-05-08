<?php

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBCommandContainer;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use Sigmalab\DatabaseEngine\Sqlite\SqliteDataSource;

require_once(__DIR__ . "/objects/schema.php");
require_once(DIR_MODULES . "/ADO/ADO.php");
require_once( __DIR__.'/env.php');

class testSqlite3Source extends xUnit_TestSuite
{
	public function testFile()
	{
		$ds = new SqliteDataSource();

		$dbfile = "/tmp/file.db";
		if (file_exists($dbfile)) unlink($dbfile);
		$ds->connect("sqlite://localhost/?database={$dbfile}");

		$this->rollupSchema($ds);

		$data = new Database\Data();
		$data->set_text("textA");

		$ds->beginTransaction();
		{
			$stmInsert = new SQLStatementInsert($data);
			if (0) {
				echo str_replace("\n", " ", $stmInsert->generate($ds->getGenerator()));
				sleep(20);
			}

			$ds->queryStatement($stmInsert);
			$this->assertEquals(1, $ds->lastID());

			$stm = new SQLStatementSelect(new Database\Data());
			$container = $stm->createResultContainer();
			$ds->queryStatement($stm, $container);
			$this->assertEquals(1, count($container->getResult()));

		}
		$ds->commitTransaction();
	}

	public function testInMemory()
	{
		$ds = new SqliteDataSource();
		$ds->connect("sqlite://localhost/?database=:memory:");

		$this->rollupSchema($ds);

		$data = new Database\Data();
		$data->set_text("textA");

		$stmInsert = new SQLStatementInsert($data);

		//uncomment for  testging DB lock
		//echo str_replace("\n", " ", $stmInsert->generate($ds->getGenerator()));
		//sleep( 20 );

		$ds->queryStatement($stmInsert);
		$this->assertEquals(1, $ds->lastID());
		$ds->commitTransaction();

		$stm = new SQLStatementSelect(new Database\Data());
		$container = $stm->createResultContainer();
		$ds->queryStatement($stm, $container);
		$this->assertEquals(1, count($container->getResult()));

	}
	public function testExceptions()
	{
		$ds = new SqliteDataSource();
		$ds->connect("sqlite://localhost/?database=:memory:");

		$this->rollupSchema($ds);

		$caught = 0;
		try {
			$stm = new SQLStatementSelect(new Database\Data());
			$stm->addExpression(new ExprEQ(new DBColumnDefinition(), 10));
			$container = $stm->createResultContainer();
			$ds->queryStatement($stm, $container);

		} catch (DatabaseException $e) {
			$caught = 1;
		}
		$this->assertEquals(1, $caught);

		$caught = 0;
		try {
			$invalidObject = new Database\Data();
			$invalidObject->set_data_id(1);
			$stm = new SQLStatementUpdate($invalidObject);
			$stm->expr = new ExprEQ(new DBColumnDefinition(), 10);
			$container = $stm->createResultContainer();
			$ds->queryStatement($stm, $container);

		} catch (DatabaseException $e) {
			$caught = 1;
		}
		$this->assertEquals(1, $caught);
	}

	/**
	 * @param SqliteDataSource $ds
	 * @return DBCommandContainer
	 * @throws DatabaseException
	 * @throws \Sigmalab\Database\DatabaseBusyException
	 */
	protected function rollupSchema(SqliteDataSource $ds): DBCommandContainer
	{
		$sql = file_get_contents(__DIR__ . "/objects/schema.sqlite");
		$ds->beginTransaction();
		$container = new DBCommandContainer();
		$ds->queryCommand($sql . ";", $container);
		$ds->commitTransaction();
		return $container;
	}
}