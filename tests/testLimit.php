<?php

use Sigmalab\Database\Sql\SQLDic;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLLimit;

require_once( DIR_MODULES . "/ADO/ADO.php");

class testLimit extends PhpTest_TestSuite
{

	function testBasic()
	{
		$stm = new SQLLimit( 10 );

		$query = $stm->generate(new SqlTestGenerator());
		TS_ASSERT_EQUALS( "LIMIT 10", $query );
	}

	function test_zero_limit_should_be_ignored_because_invalid()
	{
		
		$stm = new SQLLimit( 0 );

		$query = $stm->generate(new SqlTestGenerator());
		TS_ASSERT_EQUALS( "", $query );
	}
}

