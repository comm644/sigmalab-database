<?php /** @noinspection PhpMultipleClassesDeclarationsInOneFile */
require_once(__DIR__ . "/../ADO.php" );

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Relations\DBRelationAdapter;
use Sigmalab\Database\Core\DBObject;

class A extends DBObject
{
	public $a_id;

	public function table_name(): string
	{
		return ("tableA");
	}

	public function primary_key_value():int
	{
		return ($this->a_id);
	}

	public function createSelf(): \Sigmalab\Database\Core\IDataObject
	{
		return new self();
	}

	/**
	 * @inheritDoc
	 */
	public function set_as_mixed_by_index(int $index, $value)
	{
		// TODO: Implement set_as_mixed_by_index() method.
	}

	/**
	 * @inheritDoc
	 */
	public function get_as_mixed_by_index(int $index)
	{
		// TODO: Implement get_as_mixed_by_index() method.
	}

	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return new DBColumnDefinition('a_id');
	}
}

class B extends DBObject
{
	public $b_id;

	public function table_name(): string
	{
		return ("tableB");
	}

	public function primary_key_value(): int
	{
		return ($this->b_id);
	}

	public function createSelf(): \Sigmalab\Database\Core\IDataObject
	{
		return new self();
	}

	/**
	 * @inheritDoc
	 */
	public function set_as_mixed_by_index(int $index, $value)
	{
		// TODO: Implement set_as_mixed_by_index() method.
	}

	/**
	 * @inheritDoc
	 */
	public function get_as_mixed_by_index(int $index)
	{
		// TODO: Implement get_as_mixed_by_index() method.
	}
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return new DBColumnDefinition('b_id');
	}
}

class R
{
	public $a_id;
	public $b_id;

	public function table_name()
	{
		return ("tableR");
	}

	public function primary_key_value()
	{
		return ("");
	}
}


class ABRel extends DBRelationAdapter
{
	public function getObject($oid, $mid)
	{
		$o = new R;
		$o->a_id = $oid;
		$o->b_id = $mid;
		return ($o);
	}

	public function getDataObject(int $objectId): DBObject
	{
		$o = new A;
		$o->a_id = $oid;
		return ($o);
	}

	public  function getMemberObject(int $memberId): DBObject
	{
		$o = new B;
		$o->b_id = $mid;
		return ($o);
	}

	public function getForeignKeys()
	{
		return (array("a_id", "b_id"));
	}
}


class xtestRelations extends PhpTest_TestSuite
{

	public function test1()
	{

		$rel = new ABRel();

		$str = $rel->stmSelectChildren(1);

		TS_ASSERT_EQUALS(
			"SELECT tableB.`b_id` FROM tableB,tableR WHERE "
			. "(tableR.`b_id`=tableB.`b_id`) AND (tableR.`a_id`='1')", $str);

	}
}
