<?php /** @noinspection PhpMultipleClassesDeclarationsInOneFile */


use Sigmalab\Database\Cloneable;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\IDataSource;
use Sigmalab\Database\Sql\SQLStatement;

class MyDataSource extends IDataSource
{
	public string $_dsn = '';
	
	public function connect(string $dsn)
	{
			$this->_dsn = $dsn;
	}

	public function getDSN()
	{
		return( $this->_dsn );
	}

	public function queryStatement(SQLStatement $statement, ?DBResultContainer $resultContainer = null)
	{
		// TODO: Implement queryStatement() method.
	}

	/**
	 * @inheritDoc
	 */
	public function lastID(): int
	{
		return 0;
	}
}

class testDataSourceFactory extends PhpTest_TestSuite
{

	/** this test case show how use Data Source Provider in your programm.

	this class provides \b Factory  for creating DataSource object.
	and you can create object instance in \b uiPage constructor
	bacause object does not have internal state.
	 */
	public function testUsage()
	{
		$proto = new MyDataSource();
		
		$dsn = "mydsn://localhost/mydatabase";
		
		$ds = new MyDataSource();
		$ds->connect($dsn);


		TS_ASSERT_EQUALS( get_class( $proto ), get_class( $ds ) );
		TS_ASSERT_EQUALS( $dsn, $ds->getDSN() );
	}
}
