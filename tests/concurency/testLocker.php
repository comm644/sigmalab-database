<?php

use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use Sigmalab\DatabaseEngine\Sqlite\PdoSqliteDataSource;

require_once( __DIR__ . "/../tracer.php" );
require_once( __DIR__ . "/../objects/schema.php" );
require_once( DIR_MODULES . "/ADO/ADO.php");
require_once(__DIR__ . "/../../Sqlite/SqliteDictionary.php");
require_once(__DIR__ . "/../../Sqlite/PdoDataSource.php");
require_once( __DIR__ .'/slock.php' );
require_once(__DIR__ . '/MyDsLogger.php');

/**
 * Created by PhpStorm.
 * User: comm
 * Date: 01.06.16
 * Time: 2:03
 */
class testLocker extends PhpTest_TestSuite
{
	function test1()
	{
		$file = __DIR__ . "/database.db";
		if (file_exists($file)) unlink($file);

		$ds = new PdoSqliteDataSource();
		$ds->connect("sqlite://localhost/?database=$file");

		$ds->beginTransaction();

		$sql = file_get_contents(__DIR__ . "/../objects/schema.sqlite");
		$container = new DBResultContainer();

		$ds->queryCommand($sql, $container);

		$ds->commitTransaction();
		slock::signal('db-ready.flag');

		TS_TRACE("locker begin");
		slock::wait( 'proc-ready.flag' );

		$ds->beginTransaction();
		$data = new Data();

		$ds->queryStatement(new SQLStatementInsert($data));
		$ds->queryStatement(new SQLStatementSelect(new Data));
		$ds->commitTransaction();

		$ds->connect("sqlite://localhost/?database=$file");
		TS_TRACE("locker sleep");

		slock::signal('lock-ready.flag' );
		slock::wait('proc-ready.flag');

		$data->set_data_id(1);
		$data->set_text('blue');

		$ds->beginTransaction();
		echo "locker ";
		$ds->queryStatement(new SQLStatementUpdate($data));
		slock::signal( 'lock-ready.flag' );
		sleep( 10 );
		$ds->commitTransaction();

		TS_TRACE("locker continue");

		//$ds->commitTransaction();
		TS_TRACE("locker end");
	}
}