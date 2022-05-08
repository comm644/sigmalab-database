<?php

use Database\Data;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLGroup;
use Sigmalab\Database\Sql\SQLName;

require_once( DIR_MODULES . "/ADO/ADO.php");
require_once( dirname(__FILE__ ) . "/objects/schema.php" );


class testSqlGroup extends PhpTest_TestSuite
{

	function testString()
	{
		$expr = new SQLGroup( $this->getColumn() );
		$query = $expr->generate(new SqlTestGenerator());
		
		TS_ASSERT_EQUALS( "`column`", $query );
	}

	function testString_Table()
	{
		$expr = new SQLGroup( $this->getColumn() );
		$query = $expr->generate(new SqlTestGenerator(),'table');
		
		TS_ASSERT_EQUALS( "`table`.`column`", $query );
	}

	
	function testAscending()
	{
		$expr = new SQLGroup($this->getColumn(), true );
		$query = $expr->generate(new SqlTestGenerator());
		
		TS_ASSERT_EQUALS( "`column`", $query );
	}
	function testDescending()
	{
		$expr = new SQLGroup( $this->getColumn(), false );
		$query = $expr->generate(new SqlTestGenerator());
		
		TS_ASSERT_EQUALS( "`column`", $query );
	}

	function testName()
	{
		$expr = new SQLGroup( new DBColumnDefinition( 'column', null, null, new Data()) );
		$query = $expr->generate(new SqlTestGenerator());

		TS_ASSERT_EQUALS( "`t_data`.`column`", $query );
	}

	function testDefinition()
	{
		$proto = new Data;
		
		$expr = new SQLGroup( $proto->tag_data_id() );
		$query = $expr->generate(new SqlTestGenerator());
		TS_ASSERT_EQUALS( "`t_data`.`data_id`", $query );
	}

	/**
	 * @return DBColumnDefinition
	 */
	protected function getColumn(): DBColumnDefinition
	{
		return new DBColumnDefinition('column');
	}
}
