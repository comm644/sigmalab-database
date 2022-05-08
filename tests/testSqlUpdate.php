<?php

use Database\Data;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use Sigmalab\DatabaseEngine\Sqlite\SqliteGenerator;

require_once( dirname(__FILE__ ) . "/tracer.php" );
require_once( dirname(__FILE__ ) . "/objects/schema.php" );
require_once( dirname(__FILE__ ) . "/../ADO.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testSqlUpdate
 *
 * @author comm
 */
class testSqlUpdate extends PhpTest_TestSuite
{
    function testUseCase()
    {
        $obj = new Data();
		$obj->set_data_id(10);
        $obj->set_value(1);

        $stm = new SQLStatementUpdate($obj);


		$generator = new SqliteGenerator();
		$query = $stm->generate($generator );

        $this->assertEquals('UPDATE `t_data` SET value=1 WHERE (`t_data`.data_id = 10)', $query);
    }
	
	//WHEN primary key chnaged THEN previous key value must be used in stetement
    function testUpdatePrimaryKeyChange()
    {
        $obj = new Data();
		$obj->set_data_id(5);
		$obj->set_data_id(10);
        $obj->set_value(1);

        $stm = new SQLStatementUpdate($obj);
		$stm->enableChangePK();

        $generator = new SqliteGenerator();
		$query = $stm->generate($generator );

        $this->assertEquals('UPDATE `t_data` SET data_id=10,value=1 WHERE (`t_data`.data_id = 5)', $query);
    }
	
}


