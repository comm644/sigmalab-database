<?php

namespace Sigmalab\Database\Relations;

use Sigmalab\Database\Core\DBDataSource;
use Sigmalab\Database\Core\DBObject;
use Sigmalab\Database\Core\IDataSource;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use Sigmalab\SimpleReflection\ClassRegistry;

require_once(__DIR__ . "/DBHistory.php");

/**
 * @property array|DBHistory _history
 */
abstract class DBLinkedObject extends DBObject
{
	/** @var DBHistory[] */
	private array $_history = [];

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param IDataSource $ds
	 * @param string $name
	 * @throws \Sigmalab\Database\DatabaseException
	 */
	public function loadMembers(IDataSource $ds, string $name)
	{
		$ra = $this->getRelationAdapter($name);
		if (!$ra) return;
		$ref = ClassRegistry::createReflectionForInstance($this);

		$objects = $ra->select($this->primary_key_value(), $ds, "");
		$ref->set_as_objects($name, $objects);
	}

	/**
	 * @param IDataSource $ds
	 * @param string $name
	 * @return SQLStatementSelect|null
	 */
	public function stmLoadMembers(IDataSource $ds, string $name)
	{
		$ra = $this->getRelationAdapter($name);
		if (!$ra) return null;

		return $ra->stmSelectChildren([$this->primary_key_value()], null);
	}

#ifndef KPHP

	/** add member object
	 * @param string $name
	 * @param IDataSource $obj
	 * @return string
	 * @reflection-skip
	 */
	public function addMember(string $name, IDataSource &$obj)
	{
		if (!array_key_exists($name, $this)) $this->$name = array();

		$index = uuid();
		if (!array_key_exists($name, $this)) {
			$this->$name = array();
		}

		$this->{$name}[$index] = $obj;

		$this->_history[] = new DBHistory(DBH_ADD, $name, $index);
		return ($index);
	}
#endif

	/** update member object
	 * @param string $name
	 * @param int $index
	 * @return int
	 */
	public function updateMember(string $name, int $index)
	{
		$signAlreadyUpdated = false;
		//forget about already updated  item
		foreach (array_keys_as_ints($this->_history) as $pos) {
			if ($this->_history[$pos]->index != $index) continue;
			if ($this->_history[$pos]->op == DBH_UPDATE) {
				$signAlreadyUpdated = true;
			}
		}
		if (!$signAlreadyUpdated) {
			$this->_history[] = new DBHistory(DBH_UPDATE, $name, $index);
		}

		return ($index);
	}
#ifndef KPHP
	/**
	 * @param string $name
	 * @param int $index
	 * @reflection-skip
	 */
	public function deleteMember(string $name, int $index)
	{
		$signNewlyAdded = false;
		//forget about newly created item
		if (array_key_exists("_history", instance_to_array($this))) {
			foreach (array_keys_as_ints($this->_history) as $pos) {
				if ($this->_history[$pos]->index != $index) continue;
				if ($this->_history[$pos]->op == DBH_REMOVE) continue;
				unset($this->_history[$pos]);
				$signNewlyAdded = true;
			}
		}
		if (!$signNewlyAdded) {
			$this->_history[] = new DBHistory(DBH_REMOVE, $name, $index, $this->{$name}[$index]);
		}
		unset($this->{$name}[$index]);
	}
#endif

	/** should returns relations adapter for $name
	 * @param string $name
	 * @return DBRelationAdapter
	 */
	public function getRelationAdapter(string $name)
	{
		return (null);
	}
#ifndef KPHP
	/**
	 * @param IDataSource $ds
	 * @reflection-skip
	 */
	public function executeHistory(IDataSource &$ds)
	{
		$pk = $this->primary_key_value();

		//if object supports history
		if (!array_key_exists("_history", instance_to_array($this))) return;

		foreach ($this->_history as $info) {
			$name = $info->container;
			$index = $info->index;

			switch ($info->op) {
				case DBH_ADD:
					/** @var $obj DBLinkedObject */
					$obj = $this->{$name}[$index];

					$ds->queryStatement(new SQLStatementInsert($obj));

					//add relations
					$childID = $ds->lastID();
					$pkname = (string)$obj->getPrimaryKeyTag()->getName();
					$obj->{$pkname} = $childID;

					/** @var $ra DBRelationAdapter */
					$ra = $this->getRelationAdapter($name);
					$ra->add($pk, $childID, $ds);

					//recursive execute history
					$obj->executeHistory($ds);

					break;

				case DBH_UPDATE:
					$obj = $this->{$name}[$index];

					if ($obj->isChanged()) {
						$ds->queryStatement(new SQLStatementUpdate($obj));
					}

					//recursive execute history
					$obj->executeHistory($ds);

					break;
				case DBH_REMOVE:
					//remove relations
					$ra = $this->getRelationAdapter($name);
					$ra->remove($pk, $index, $ds);

					//remove object
					$obj = &$info->deletedObject;
					if (!$obj) break;

					//recursive execute history before object
					$obj->executeHistory($ds);

					$stm = new SQLStatementDelete($obj);
					$stm->setExpression($obj->get_condition());
					$ds->queryStatement($stm);

					unset($info->deletedObject);
					break;
				case DBH_ADDLINK:
					//add relations
					$childID = $index;
					$ra = $this->getRelationAdapter($name);
					$ra->add($pk, $childID, $ds);
					break;

				case DBH_REMOVELINK:
					//remove relations
					$childID = $index;
					$ra = $this->getRelationAdapter($name);
					$ra->remove($pk, $childID, $ds);
					break;
			}
		}
	}
#endif
}
