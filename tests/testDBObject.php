<?php
require_once( dirname(__FILE__ ) . "/tracer.php" );
require_once( dirname(__FILE__ ) . "/objects/schema.php" );
require_once( DIR_MODULES . "/ADO/ADO.php");
require_once( __DIR__.'/env.php');
class C1
{
	var $field;

	function method()
	{
		return "text";
	}
}

class testDBObject extends xUnit_TestSuite
{
	function test1()
	{
		$obj = new C1;
		
		$rc= property_exists( $obj, 'field' );
		$this->assertEquals( true, $rc );
		
		$rc= property_exists( $obj, "unexists");
		$this->assertEquals( false, $rc );
	}
	function test2()
	{
		$obj = "str";

		$this->assertEquals( FALSE, is_object( $obj) &&  get_class( $obj ) );
	}

}

