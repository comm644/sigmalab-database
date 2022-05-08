<?php

use Database\Data;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLOrder;

require_once( DIR_MODULES . "/ADO/ADO.php");
require_once( dirname(__FILE__ ) . "/objects/schema.php" );

class testSQLOrder extends PhpTest_TestSuite
{

	function testString()
	{
		$expr = new SQLOrder( new SQLName(null, 'column') );

		
		$query = $expr->generate(new SqlTestGenerator());
		
		TS_ASSERT_EQUALS( "`column` ASC", $query );
	}

	function testString_Table()
	{
		$expr = new SQLOrder( new SQLName(null, 'column') );
		$query = $expr->generate(new SqlTestGenerator(),'table');
		
		TS_ASSERT_EQUALS( "`column` ASC", $query );
	}

	
	function testAscending()
	{
		$expr = new SQLOrder(  new SQLName(null, 'column'), true );
		$query = $expr->generate(new SqlTestGenerator());
		
		TS_ASSERT_EQUALS( "`column` ASC", $query );
	}
	function testDescending()
	{
		$expr = new SQLOrder(  new SQLName(null, 'column'), false );
		$query = $expr->generate(new SqlTestGenerator());
		
		TS_ASSERT_EQUALS( "`column` DESC", $query );
	}

	function testName()
	{
		$expr = new SQLOrder( new SQLName( 'table', 'column') );
		$query = $expr->generate(new SqlTestGenerator());

		TS_ASSERT_EQUALS( "`table`.`column` ASC", $query );
	}

	function testDefinition()
	{
		$proto = new Data;
		
		$expr = new SQLOrder( $proto->tag_data_id() );
		$query = $expr->generate(new SqlTestGenerator());
		TS_ASSERT_EQUALS( "`t_data`.`data_id` ASC", $query );
	}
}
