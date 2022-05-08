<?php

use Database\Data;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\ExprIN;
use Sigmalab\Database\Expressions\ExprLike;
use Sigmalab\Database\Expressions\ExprOR;
use Sigmalab\Database\Expressions\ExprRange;
use Sigmalab\Database\Sql\SQLValue;
use Sigmalab\DatabaseEngine\Sqlite\PdoSqliteDataSource;

require_once( __DIR__ . "/../ADO.php" );
require_once( __DIR__ . "/objects/schema.php" );
require_once __DIR__ . '/mocks.php';
require_once( __DIR__.'/env.php');

class testExpressions extends xUnit_TestSuite
{
	public function suiteStart()
	{
	}

	function getCompiler()
	{
        $ds = new PdoSqliteDataSource();
		$compiler = new ECompilerSQL($ds->getGenerator());
		$compiler->generationMode = \Sigmalab\Database\Core\DBGenCause::Where;
		return $compiler;
	}
	
	function testAND_OR()
	{
		$expr = new ExprAND([
			new SQLValue(1),
				new ExprOR( [
					new SQLValue(2),
					new SQLValue(3)
				]),
				new SQLValue("string"),
				new SQLValue(4)
			]);
			
		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "(1 AND (2 OR 3) AND \"string\" AND 4)", $query );
	}
	function testAND_OR_2()
	{
		$expr = new ExprAND([
			new SQLValue(1),
				new ExprOR( [
					new SQLValue(2),
					new SQLValue(3)]),
				new SQLValue("string"),
				new SQLValue(4)
			]);

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "(1 AND (2 OR 3) AND \"string\" AND 4)", $query );
	}
	public function testEmpty()
	{
		$expr = new ExprAND( array() );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "", $query );
	}

	//invalid type.
	public function xtestNull()
	{
		$expr = new ExprAND( null );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "", $query );
	}
	public function testIN()
	{
		$expr = new ExprIN(  $this->getDataColumn(), array( 1, 'a', NULL ) );
		
		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "`t_data`.column IN (1,\"a\") AND `t_data`.column IS NULL", $query );
	}
	public function testIN_tag()
	{
		$proto = new Data;
		
		$expr = new ExprIN( $proto->tag_data_id(), array( 1, 'a', NULL ) );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
//		TS_ASSERT_EQUALS( "`t_data`.data_id IN (1,\"a\") AND `t_data`.data_id IS NULL", $query );
		//"a" must be converted to in because column type is int
		$this->assertEquals( "`t_data`.data_id IN (1,0) AND `t_data`.data_id IS NULL", $query );
	}
	public function testIN_empty_set()
	{
		$hasException = false;
		try {
			$expr = new ExprIN($this->getDataColumn(), array());
		}
		catch (Exception $exception) {
			$hasException = true;
		}
		$this->assertEquals(true, $hasException);

//		$compiler = $this-> getCompiler();
//		$query = $compiler->compile( $expr );
//		TS_ASSERT_EQUALS( "", $query );
	}
	public function testIN_only_null()
	{
		$expr = new ExprIN(  $this->getDataColumn(), array(NULL) );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "`t_data`.column IS NULL", $query );
	}
	public function testIN_only_one_value()
	{
		$expr = new ExprIN( $this->getDataColumn(), array( 1 ) );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "`t_data`.column IN (1)", $query );
	}
	
	public function testEQUAL_array()
	{
		$hasException = false;
		try {
			$expr = new ExprEQ(new DBColumnDefinition('column'), array(1, 'a', null));
		}
		catch (\Sigmalab\Database\DatabaseArgumentException $e)
		{
			$hasException = true;
		}
		$this->assertEquals(true, $hasException, "Array not supported");

//		$compiler = $this-> getCompiler();
//		$query = $compiler->compile( $expr );
//		$this->assertEquals( "(column = 1 AND column = \"a\" AND column = NULL)", $query );
	}

	function testEQUAL_2()
	{
		$expr = new ExprEQ( new DBColumnDefinition('column'),1 );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "(column = 1)", $query );
	}
	function testEQUAL_0()
	{
		$expr = new ExprEQ( new DBColumnDefinition('column'), 0);

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "(column = 0)", $query );
	}

	
	function testEQ_type_datetime()
	{
		$data = new Data();
		$expr = new ExprEQ($data->tag_date(), 1 );
		
		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "(`t_data`.date = '1970-01-01T03:00:01')", $query );
	}

	function testLike()
	{
		$expr = new ExprLike( new DBColumnDefinition('column'), 'text' );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "(column LIKE '%text%')", $query );
	}
	function testName_where()
	{
		$compiler = $this-> getCompiler();
		$compiler->generationMode = \Sigmalab\Database\Core\DBGenCause::Where;
		$name = $compiler->getName( $this->getDataColumn() );

		$this->assertEquals( "`t_data`.column", $name );
	}

	function testRange()
	{
		$expr = new ExprRange( new DBColumnDefinition('column'), 2, 3 );

		$compiler = $this-> getCompiler();
		$query = $compiler->compile( $expr );
		$this->assertEquals( "((column >= 2) AND (column <= 3))", $query );
	}

	/**
	 * @return DBColumnDefinition
	 */
	protected function getDataColumn(): DBColumnDefinition
	{
		return new DBColumnDefinition('column', null, null, new Data());
	}

}
