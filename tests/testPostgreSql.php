<?php

use Database\Data;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use Sigmalab\DatabaseEngine\Postgre\PostgrePdoDataSource;

require_once __DIR__ .'/objects/schema.php';


/**
 * Created by PhpStorm.
 * User: comm
 * Date: 13.02.17
 * Time: 1:22
 */
class testPostgreSql //extends PhpTest_TestSuite
{
	function test1()
	{
		$resetdb = 1;
		if  ($resetdb) {
			@shell_exec('dropdb tests');
			@shell_exec('createdb tests');
		}

		$ds = new PostgrePdoDataSource();
		$ds->connect('pgsql://comm:admin@localhost/tests');

		if  ($resetdb) {
			$container = new DBResultContainer();
			$ds->queryCommand(file_get_contents(__DIR__ . '/objects/schema.psql'), $container);
		}

		$data = new Data();
		$data->setTableAlias( "d" );
		$data->set_string( "value" );
		$data->set_date( "2009-07-07 23:50:20.10" );
		$data->set_enum('red');
		$data->set_text('some text');
		$data->set_value(10);
		$data->set_real(123.50);
		$data->set_blob("some bytes here \001\002\003");

		$stm = new SQLStatementInsert( $data );

		$res = $stm->createResultContainer(true);
		$ds->queryStatement($stm, $res);
		$this->assertEquals(1, $ds->lastID());

		$res = $stm->createResultContainer(true);
		$ds->queryStatement($stm, $res);
		$this->assertEquals(2, $ds->lastID());


		$stm = new SQLStatementSelect(new Data());
		$res = $stm->createResultContainer(true);
		$ds->queryStatement($stm, $res);
		//print_r( $res->data);

		$this->assertEquals(2, count ($res->data));

		/** @var Data $data */
		$data =$res->data[1];
		$data ->set_value(20);
		$stm = new SQLStatementUpdate($data);
		$res = $stm->createResultContainer(true);
		$ds->queryStatement($stm, $res);

		$this->assertEquals(1, $res->data[0]);
	}

}