<?php

use Database\table_t_base;
use Database\table_t_details;
use Database\table_t_subdetails;
use Sigmalab\Database\Core\DBInsertOneResult;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Storage\ExtendedObjectsStorage;
use Sigmalab\Database\Storage\IStatementRunner;
use Sigmalab\DatabaseEngine\Sqlite\PdoSqliteDataSource;

require_once( DIR_MODULES . "/ADO/ADO.php");
require_once( __DIR__ .'/objects/schema.php');
require_once( __DIR__.'/env.php');

/**
 *  Base1 -> Base2 -> Details
 *
 *  active record ??
 */
class BaseClass  extends table_t_base
{
}
class DetailsClass extends table_t_details
{
}
class SubDetails extends table_t_subdetails
{

}

class MyContainer extends DBResultContainer
{

	/**
	 * @inheritDoc
	 */
	public function fromSQL(array $sqlLine): \Sigmalab\Database\Core\IDataObject
	{
		$object = new DetailsClass();
		foreach ($sqlLine as $key=>$value) {
			$object->$key = $value;
		}
		return $object;
	}
}
class testExtendsObjectStorage extends xUnit_TestSuite
	implements IStatementRunner
{
	/**
	 * @var PdoSqliteDataSource
	 */
	public $ds;

	function setUp(): void
	{
		$file = __DIR__ . "/database.db";
		if ( file_exists( $file ) ) unlink( $file );

		$ds = new PdoSqliteDataSource();
		$ds->connect("sqlite://localhost/?database=:memory:");

		$ds->beginTransaction();

		$sql= file_get_contents( __DIR__ ."/objects/schema.sqlite" );
		$container = new MyContainer();

		$ds->queryCommand($sql, $container);

		$this->ds = $ds;
	}
	function tearDown(): void
	{
		unset( $this->ds );
	}

	function testInsert()
	{
		$stor = new ExtendedObjectsStorage($this, new DetailsClass());

		//construct object
		$obj = new DetailsClass();

		$obj->set_detailsData( 10 );
		$obj->set_baseData( 20 );


		$stor->insert($obj);

		$this->assertEquals(1, $obj->get_base_id());
		$this->assertEquals(1, $obj->get_details_id());

		$proto = new DetailsClass();

		$objs = $this->execute($stor->stmSelect() );
		$this->assertEquals(1, count( $objs));

		/** @var $obj DetailsClass */
		$obj = array_first_value($objs);
		$this->assertEquals(1, $obj->get_base_id());
		$this->assertEquals(1, $obj->get_details_id());
		$this->assertEquals(20, $obj->get_baseData());
		$this->assertEquals(10, $obj->get_detailsData());


		$obj->set_baseData(30);
		$obj->set_detailsData(40);
		$stor->update($obj);

		$objs = $this->execute($stor->stmSelect() );
		$obj = array_first_value($objs);
		$this->assertEquals(30, $obj->get_baseData());
		$this->assertEquals(40, $obj->get_detailsData());
	}

	function testCreateSubDetails()
	{
		$stor = new ExtendedObjectsStorage($this, new SubDetails());

		//construct object
		$obj = new SubDetails ();

		$obj->set_baseData( 10 );
		$obj->set_detailsData( 20 );
		$obj->set_subDetailsData(30);

		$stor->insert($obj);

		$objs = $this->execute($stor->stmSelect() );
		$this->assertEquals(1, count( $objs));
		/** @var $obj SubDetails */
		$obj = array_first_value($objs);

		$this->assertEquals(10, $obj->get_baseData());
		$this->assertEquals(20, $obj->get_detailsData());
		$this->assertEquals(30, $obj->get_subDetailsData());
	}
	function testListSubdetails()
	{
		$this->testCreateSubDetails();

		$stor = new ExtendedObjectsStorage($this, new SubDetails());
		$objs = $this->execute($stor->stmSelect() );
		$this->assertEquals(1, count( $objs));
		/** @var $obj SubDetails */
		$obj = array_first_value($objs);

		$this->assertEquals(10, $obj->get_baseData());
		$this->assertEquals(20, $obj->get_detailsData());
		$this->assertEquals(30, $obj->get_subDetailsData());
	}

	function testUpdateSubDetails()
	{
		$this->testCreateSubDetails();

		$stor = new ExtendedObjectsStorage($this, new SubDetails());

		$objs = $this->execute($stor->stmSelect() );
		/** @var $obj SubDetails */
		$obj = array_first_value($objs);

		$obj->set_baseData( 110 );
		$obj->set_detailsData( 120 );
		$obj->set_subDetailsData(130);

		$stor->update($obj);

		$objs = $this->execute($stor->stmSelect() );
		/** @var $obj SubDetails */
		$obj = array_first_value($objs);

		$this->assertEquals(110, $obj->get_baseData());
		$this->assertEquals(120, $obj->get_detailsData());
		$this->assertEquals(130, $obj->get_subDetailsData());
	}

	function execute(SQLStatement $stm): array
	{
		$res = $stm->createResultContainer(true);
		$this->ds->queryStatement($stm, $res);

		$lastID = -1;
		if ( $stm instanceof SQLStatementInsert) {
			$lastID = $this->ds->lastID();
		}
		if ( $lastID != -1 ) {
			return [new DBInsertOneResult($lastID)];
		}
		return $res->getResult();
	}
}