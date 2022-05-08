<?php

use Database\Data;
use Sigmalab\Database\Core\DBCommandContainer;
use Sigmalab\Database\Core\DBRowsAffectedResult;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\DatabaseEngine\Sqlite\PdoSqliteDataSource;
use Sigmalab\DatabaseEngine\Sqlite\SqliteGenerator;

require_once( __DIR__ . "/tracer.php" );
require_once( __DIR__ . "/objects/schema.php" );
require_once( DIR_MODULES . "/ADO/ADO.php");
require_once( __DIR__.'/env.php');


class testSqlite extends xUnit_TestSuite
{
	function ws($str )
	{
		return str_replace("\n", "", $str );
	}

	function executeStatement( $db, $sql )
	{
		$query = $db->query( $sql .";", PDO::FETCH_CLASS, "stdclass" );

	//	print_r( $query);
		
	//	print("\nerror:");
		//print_r( $db->errorCode() );
//		print_r( $db->errorInfo());
		return $query;
	}

	function testDirectPDO()
	{
		
		$file = __DIR__ . "/database.db";
		$mode = 0666;
		$error_message = null;

		if ( file_exists( $file ) ) unlink( $file );

		$db = new PDO( "sqlite:$file");
		$db->beginTransaction();


		$sql= file_get_contents( __DIR__ ."/objects/schema.sqlite" );
		

		$db->exec($sql.";");
//		$this->executeStatement($db, $batch);
		
/*		if ( $rc === fALSE ) {
			echo "db error: " . $msg;
		}
*/
		$gen = new SqliteGenerator();

		
		$data = new Data();
		$data->setTableAlias( "d" );
		$data->set_string( "value" );
		$data->set_date( strtotime("2009-07-07 23:50:20.10") );
//		$data->set_enum('red');
		$data->set_text('some text');
		$data->set_value(10);
		$data->set_real(123.50);
		$data->set_blob("bytes\001\002\003");
		
		
		$stm = new SQLStatementInsert( $data );
		$sql= $gen->generate( $stm );
	//		print $sql."\n";

//		print "\ninsert: $sql";
		$db->exec($sql.";");
		$db->exec($sql.";");
		//		$this->executeStatement($db, $sql);
//		print "\n";

		$db->commit();
		
		$stm = new SQLStatementSelect( $data );

		$sql = $gen->generate( $stm );
		

		//print $sql ."\n";
		
		$expected = "SELECT"
		    ." `d`.data_id AS data_id,"
			." `d`.date AS date,"
			." `d`.value AS value,"
			." `d`.string AS string,"
			." `d`.text AS text,"
//			." `d`.enum AS enum,"
			." `d`.blob AS blob,"
			." `d`.real AS real,"
			." `d`.dictionary_id AS dictionary_id"
			." FROM `t_data` AS `d`";
		
		$this->assertEquals( $expected, $this->ws($sql) );
		

		$rc = $this->executeStatement($db, $sql);
		
		$array =$rc->fetchAll();

//		print_r( $array);
		$this->assertEquals(1, (int)$array[0]->data_id);
//		$this->assertEquals($data->enum, $array[0]->enum);
		$this->assertEquals($data->string, $array[0]->string);
		$this->assertEquals($data->value, (int)$array[0]->value);
		$this->assertEquals("2009-07-07T23:50:20", $array[0]->date); //Database has row value as datetime string
		$this->assertEquals((string)$data->real, $array[0]->real);
		
/*		
		if ( $result === fALSE ) {
			echo "db error: " . $msg;
		}*/
	}
	
	function testWithDataSource()
	{
		$file = __DIR__ . "/database.db";
		if ( file_exists( $file ) ) unlink( $file );
		
				
		$ds = new PdoSqliteDataSource();
		$ds->connect("sqlite://localhost/?database=$file");
//		$ds->signShowQueries = true;

		$ds->beginTransaction();
		
		$sql= file_get_contents( __DIR__ ."/objects/schema.sqlite" );
		$container = new DBCommandContainer();
		
		$ds->queryCommand($sql, $container);
		
		$data = new Data();
		$data->setTableAlias( "d" );
		$data->set_string( "value" );
		$data->set_date( mktime(13, 27, 20, 9, 6, 2009));
//		$data->set_enum('red'); //not supported
		$data->set_text('some text');
		$data->set_value(10);
		$data->set_real(123.62);
		$data->set_blob("bytes\001\002\003");
		
		
		$stm = new SQLStatementInsert( $data );
		$container = $stm->createResultContainer();
		$ds->queryStatement($stm, $container);
		$this->assertEquals(new DBRowsAffectedResult(1), $container->getResult()[0], "affected rows");

		$ds->queryStatement($stm, $container);
		$this->assertEquals(new DBRowsAffectedResult(1), $container->getResult()[0], "affected rows");
		
		
		
		$stm = new SQLStatementSelect( $data );
		$container = $stm->createResultContainer();
		$ds->queryStatement($stm, $container);
		
		$array = $container->getResult();
		
		$this->assertEquals( 2, count( $array ) );
		
		$this->assertEquals(1, intval($array[1]->data_id));
//		$this->assertEquals($data->enum, $array[1]->enum);
		$this->assertEquals($data->string, $array[1]->string);
		$this->assertEquals($data->value, intval($array[1]->value));
		$this->assertEquals($data->date, $array[1]->date);
		$this->assertEquals($data->blob, $array[1]->blob);
		$this->assertEquals($data->real, $array[1]->real);
		
		$this->assertEquals(strftime( "%c", $data->date), strftime( "%c", $array[1]->date));

		$proto = new Data() ;
		
		$stm = new SQLStatementDelete( $proto  );
		$stm->setExpression( new ExprEQ( $proto->getPrimaryKeyTag(), 1));
		$container = $stm->createResultContainer();
		$ds->queryStatement($stm, $container);
		
		$this->assertEquals(new DBRowsAffectedResult(1), $container->getResult()[0], "affected rows");
		
		$stm = new SQLStatementSelect( $data );
		$container = $stm->createResultContainer();
		$ds->queryStatement($stm, $container);
		$array = $container->getResult();

		$ds->commitTransaction();
	}
	
	function printResult( $pdoStm )
	{
		if ( !$pdoStm ) {
			print( "{ null }");
			return;	
		}
		foreach ($pdoStm as $row) {
			print_r($row);
		}		
	}
}

