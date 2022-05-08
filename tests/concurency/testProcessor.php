<?php

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
class testProcessor extends PhpTest_TestSuite
{
	function test1()
	{
		slock::wait( 'db-ready.flag' );
		$file = __DIR__ . "/database.db";
		$ds = new PdoSqliteDataSource();
		$ds->connect("sqlite://localhost/?database=$file");

		TS_TRACE("processor begin");

		slock::signal('proc-ready.flag');

		$data = new Data();

		//$ds->queryStatement(new SQLStatementInsert($data));
		$data->set_data_id( 1 );
		$data->set_string( "red" );
		$ds->queryStatement(new SQLStatementUpdate($data));


		TS_TRACE("processor begin-start");
		slock::wait('lock-ready.flag');
		$ds->queryStatement(new SQLStatementSelect(new Data));

		slock::signal('proc-ready.flag');

		slock::wait('lock-ready.flag');

        $ds->queryStatement(new SQLStatementUpdate($data));

//		$ds->commitTransaction();

		TS_TRACE("processor end");
	}
}