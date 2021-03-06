<?php

use Database\Data;
use Database\Dictionary;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLJoin;

require_once( dirname(__FILE__ ) . "/tracer.php" );
require_once( dirname(__FILE__ ) . "/objects/schema.php" );
require_once( DIR_MODULES . "/ADO/ADO.php");

class testJoin extends PhpTest_TestSuite
{
	function ws($str )
	{
		return str_replace("\n", "", $str );
	}
	function testJoin_Automatic()
	{
		$data = new Data();
		
		$join = SQLJoin::createByKey( $data->key_dictionary_id() );

		$gen = new SqlTestGenerator();
		
		$query = $join->generate($gen);

		$expected = "LEFT JOIN `t_dictionary` ON (`t_dictionary`.`dictionary_id` = `t_data`.`dictionary_id`)";
		TS_ASSERT_EQUALS( $expected, $this->ws($query) );
	}

	function testJoin_Primary_Alias()
	{
		$data = new Data();
		$data->setTableAlias( "d" );
		
		$join = SQLJoin::createByKey( $data->key_dictionary_id() );

		$gen = new SqlTestGenerator();
		
		$query = $join->generate($gen);

		$expected = "LEFT JOIN `t_dictionary` ON (`t_dictionary`.`dictionary_id` = `d`.`dictionary_id`)";
		TS_ASSERT_EQUALS( $expected, $this->ws($query) );
	}
	function testJoin_Foreign_Alias()
	{
		$data = new Data();
		$data->setTableAlias( "d" );

		$dic = new Dictionary();
		$dic->setTableAlias( "dic" );

		
		$join = SQLJoin::createByKey( $data->key_dictionary_id($dic) );

		$gen = new SqlTestGenerator();
		
		$query = $join->generate($gen);

		$expected = "LEFT JOIN `t_dictionary` AS `dic` ON (`dic`.`dictionary_id` = `d`.`dictionary_id`)";
		TS_ASSERT_EQUALS( $expected, $this->ws($query) );
	}
}


