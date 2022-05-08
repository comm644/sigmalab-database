<?php

use Database\Data;
use Database\DataNotNullable;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\DatabaseEngine\Sqlite\PdoSqliteDataSource;

require_once( dirname(__FILE__ ) . "/tracer.php" );
require_once( dirname(__FILE__ ) . "/objects/schema.php" );
require_once( dirname(__FILE__ ) . "/../ADO.php");
require_once( __DIR__.'/env.php');

/**
 * Description of testSqlInsert
 *
 * @author comm
 */
class testSqlInsert extends xUnit_TestSuite
{
	function ws($str )
	{
		return str_replace("\n", "", $str );
	}
	function testPartialInsert_insertsAllFields()
	{
		$obj = new DataNotNullable();
		$obj->set_valueA("value");
		$stm = new SQLStatementInsert($obj);

		$query = $stm->generate($this->getGenerator());

		$this->assertEquals('INSERT INTO `t_dataNotNullable` ( valueA,valueB ) VALUES ( "value",'."\n".'"" )', $query);
	}
	function testInsert_datetime()
	{
		$obj = new \Database\DataDateTime();
		$obj->set_value(mktime(5, 10, 30, 3, 27, 2022));
		$stm = new SQLStatementInsert($obj);

		$query = $stm->generate($this->getGenerator());

		$this->assertEquals('INSERT INTO `t_datatime` ( value ) VALUES ( \'2022-03-27T05:10:30\' )', $query);
	}

    //put your code here
    function test1()
    {
        $obj = new Data();
        $obj->set_string('string\\path');
        $obj->set_value(1);
        $obj->set_date(mktime(12, 30, 45, 4, 10, 2010));

        $stm = new SQLStatementInsert($obj);

		$query = $stm->generate($this->getGenerator());

        $this->assertEquals('INSERT INTO `t_data` ( date,value,string,text,blob,real,dictionary_id ) '
                .'VALUES ( \'2010-04-10T12:30:45\',1,"string\\path",NULL,NULL,NULL,NULL )', $this->ws($query) );
    }
	function xtestInsertSet()
	{
		$data = new Data();
		$data->set_data_id( 100 );
		$data->set_value( 'value' );

		$stm = new SQLStatementInsert( $data );

		$query = $stm->generate($this->getGenerator());

		$expected = "INSERT INTO `t_data` SET "
			."date=NULL,"
			."value=0,"
			."string=NULL,"
			."text=NULL,"
			."blob=NULL,"
			."real=NULL,"
			."dictionary_id=NULL";

		TS_ASSERT_EQUALS( $expected, $query );
	}
	function testInsertValues()
	{
		$data = new Data();
		$data->set_data_id( 100 );
		$data->set_value( 200 );

		$stm = new SQLStatementInsert( $data );

		$query = $stm->generate($this->getGenerator());

		$expected = "INSERT INTO `t_data` "
            ."( date,value,string,text,blob,real,dictionary_id )"
            ." VALUES"
            ." ( NULL,200,NULL,NULL,NULL,NULL,NULL )";

		$this->assertEquals( $expected, $this->ws($query)  );
	}
	function testInsertValuesZero()
	{
		$data = new Data();
		$data->set_value( 0 );

		$stm = new SQLStatementInsert( $data );

		$query = $stm->generate($this->getGenerator());

		$expected = "INSERT INTO `t_data` "
            ."( date,value,string,text,blob,real,dictionary_id )"
            ." VALUES"
            ." ( NULL,0,NULL,NULL,NULL,NULL,NULL )";

		$this->assertEquals( $expected, $this->ws($query)  );
	}

	/**
	 * @throws Exception
	 */
	function testInsertValues100()
	{
		$data = new Data();
		$data->set_value( 100 );

		$stm = new SQLStatementInsert( $data );

		$query = $stm->generate($this->getGenerator());

		$expected = "INSERT INTO `t_data` "
            ."( date,value,string,text,blob,real,dictionary_id )"
            ." VALUES"
            ." ( NULL,100,NULL,NULL,NULL,NULL,NULL )";

		$this->assertEquals( $expected, $this->ws($query)  );
	}
	function testInsertValuesForArray()
	{
		$data = new Data();
		$data->set_data_id( 100 );
		$data->set_value( 1001 );
		

		$stm = new \Sigmalab\Database\Sql\SQLStatementInsertBulk( array( $data, $data ));

		$query = $stm->generate($this->getGenerator());

		$expected = "INSERT INTO `t_data` "
            ."( date,value,string,text,blob,real,dictionary_id )"
            ." VALUES"
            ." ( NULL,1001,NULL,NULL,NULL,NULL,NULL )"
		    .",( NULL,1001,NULL,NULL,NULL,NULL,NULL )"
		;

		$this->assertEquals( $expected, $this->ws($query)  );
	}


	function xtestInsertSet_withPK()
	{
		$data = new Data();
		$data->set_data_id( 100 );
		$data->set_value( 'value' );

		$stm = new SQLStatementInsert( $data, true );

		$query = $stm->generate($this->getGenerator());

		$expected = "INSERT INTO `t_data` SET "
			."data_id=100,"
			."date=NULL,"
			."value=0,"
			."string=NULL,"
			."text=NULL,"
			."enum="
			."blob=NULL,"
			."real=NULL,"
			."dictionary_id=NULL";

		$this->assertEquals( $expected, $query );
	}
	function testInsertValues_withPK()
	{
		$data = new Data();
		$data->set_data_id( 100 );
		$data->set_value( 200 );

		$stm = new SQLStatementInsert( $data, true );

		$query = $stm->generate($this->getGenerator());

		$expected = "INSERT INTO `t_data` "
			."( data_id,date,value,string,text,blob,real,dictionary_id )"
			." VALUES ( 100,NULL,200,NULL,NULL,NULL,NULL,NULL )";

		$this->assertEquals( $expected, $this->ws($query) );
	}

	/**
	 * @return SQLGenerator
	 */
	private function getGenerator()
	{
		$ds = new PdoSqliteDataSource();
		$generator = $ds->getGenerator();
		return $generator;
	}
}
