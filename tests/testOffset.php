<?php

use Sigmalab\Database\Sql\SQLDic;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLOffset;

require_once( DIR_MODULES . "/ADO/ADO.php");


class testOffset extends PhpTest_TestSuite
{

	function testBasic()
	{
		$stm = new SQLOffset( 10 );

		$query = $stm->generate(new SqlTestGenerator(new SQLDic()));
		TS_ASSERT_EQUALS( "OFFSET 10", $query );
	}

	function test_zero_offset_should_be_ignored()
	{
		$stm = new SQLOffset( 0 );

		$query = $stm->generate(new SqlTestGenerator(new SQLDic()));
		TS_ASSERT_EQUALS( "", $query );
	}
}
