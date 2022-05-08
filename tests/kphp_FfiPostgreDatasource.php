<?php

use Database\Data;
use Reflection\AppReflectionRegistry;
use Sigmalab\Database\Core\DBArrayResult;
use Sigmalab\Database\Core\DBCommandContainer;
use Sigmalab\Database\Core\DBRowsAffectedResult;
use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Sql\SQLFunction;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementSelectResult;
use Sigmalab\DatabaseEngine\PostgreFFI\PostgreDataSourceFFI;
use Sigmalab\DatabaseEngine\Sqlite\FfiSqliteDataSource;
use Sigmalab\DatabaseEngine\Sqlite\PdoSqliteDataSource;
use Sigmalab\DatabaseEngine\Sqlite\SqliteGenerator;

#ifndef KPHP
require_once(__DIR__ . "/../ADO.php");
require_once(__DIR__ . "/objects/schema.php");
#endif


class kphpFfiPostgreDatasource
{
	public function ws($str)
	{
		return str_replace("\n", "", $str);
	}
//
//	public function executeStatement(FfiSqliteDataSource $db, string $sql)
//	{
//		$query = $db->query($sql . ";", PDO::FETCH_CLASS, "stdclass");
//
//		//	print_r( $query);
//
//		//	print("\nerror:");
//		//print_r( $db->errorCode() );
////		print_r( $db->errorInfo());
//		return $query;
//	}

	public function testCycle()
	{
		$file = __DIR__ . "/database.db";
		$error_message = null;

		if (file_exists($file)) unlink($file);

		$db = new \Sigmalab\DatabaseEngine\PostgreFFI\PostgreDataSourceFFI();
		$db->connect("pgsql://tests_admin:tests_admin_password@localhost/?database=tests");

		$this->rollupSchema($db);

		$blob = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';

		$data = new Data();
		$db->beginTransaction();
		for ($i = 0; $i < 5; ++$i)
		{
			$gen = new SqliteGenerator();
			$data = new Data();
			$data->setTableAlias("d");
			$data->set_string("value" . $i);
//			$data->set_date("2009-07-07 23:50:20.10");
//			$data->set_enum('red');
			$data->set_text('some text'. $i);
			$data->set_value(10 + $i);
			$data->set_real(123.50 + ($i * 10));
			$data->set_blob($blob);


			$stmInsert = new SQLStatementInsert($data);
			$db->queryStatement($stmInsert);
		}

		$db->commitTransaction();



		$stmSelect = new SQLStatementSelect($data);
		$selectRessult = $stmSelect->createResultContainer(false);
		$db->queryStatement($stmSelect, $selectRessult);
		$this->printResult($selectRessult);



		$stmCount = new SQLStatementSelect(new Data());
		$stmCount->resetColumns();
		echo "class:" . get_class($stmCount->object) . "\n";
		echo "class:" . get_class($stmCount->object->getPrimaryKeyTag()) . "\n";


		$stmCount->addColumn(SQLFunction::count($stmCount->object->getPrimaryKeyTag(), "count"));
		echo("sql:".$stmCount->generate($db->getGenerator()));
		$stmCount->object = new DBArrayResult($stmCount->object);
		$countResult = $stmCount->createResultContainer(false);
		$db->queryStatement($stmCount, $countResult);
		echo "\n\ncount: ". $countResult->getResult()[0]->getValue("count")."\n";

		$proto = new Data();
		$stmOne = new SQLStatementSelect($proto);
		$stmOne->addExpression(ExprEQ::eqInt($proto->tag_data_id(), 1));
		$selectResult = $stmOne->createResultContainer(false);
		$db->queryStatement($stmOne, $selectResult);
		/** @var Data $one */
		$one = instance_cast($selectResult->getResult()[0], Data::class);
		$one->set_blob( $one->get_blob() . "- updated");
		$db->queryStatement(new \Sigmalab\Database\Sql\SQLStatementUpdate($one));

		echo "updated:";
		$selectResult = $stmOne->createResultContainer(false);
		$db->queryStatement($stmOne, $selectResult);
		$this->printResult($selectResult);

//		$container= $stmInsert->createResultContainer();
//		$rc = $db->queryStatement($stmInsert, $container);
	}

	public function printResult(SQLStatementSelectResult $container)
	{
		foreach ($container->getResult() as $data) {
			echo "row: " . (string)json_encode(instance_to_array($data)) ."\n";
		}
	}

	/**
	 * @return DBCommandContainer
	 * @throws DatabaseException
	 * @throws DatabaseBusyException
	 */
	protected function rollupSchema(PostgreDataSourceFFI $ds): DBCommandContainer
	{
		$sql = file_get_contents(__DIR__ . "/objects/schema.psql");
		$ds->beginTransaction();
		$container = new DBCommandContainer();
		foreach( explode(";", $sql) as $line ) {
			$ds->queryCommand($line . ";", $container);
			echo "rc: ".$ds->getEngineError()."\n";
		}
		$ds->commitTransaction();
		return $container;
	}

}

#ifndef KPHP
if  (!function_exists('assert'))
#endif
{
	function assert($condition)
	{
		if (!$condition) exit (1);
	}
}

require_once __DIR__.'/../../../src/core/AutoLoader.php';
\core\AutoLoader::scan([
	__DIR__,
	__DIR__.'/objects',
	__DIR__.'/objects/Reflection',
	__DIR__.'/../../logger'
]);
require_once __DIR__.'/objects/Reflection/AppReflectionRegistry.php';

AppReflectionRegistry::init();
$logger = new Logger("ffi.log");
Logger::setInstance($logger);

$test = new kphpFfiPostgreDatasource();
$test->testCycle();