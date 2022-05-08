<?php

namespace Sigmalab\Database\Storage;

use Helper;
use Sigmalab\Database\Core\DataSourceLogger;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBForeignKey;
use Sigmalab\Database\Core\DBInsertOneResult;
use Sigmalab\Database\Core\DBObject;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\ExprIN;
use Sigmalab\Database\Sql\SQLJoin;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;
use Sigmalab\IsKPHP;
use Sigmalab\SimpleReflection\ClassRegistry;

/**
 * Class ExtendedObjectsStorage provides simple storage for 1 level inheritance
 */
class ExtendedObjectsStorage
{
	/**  @var IDataObject */
	public IDataObject $proto;

	/** @var IDataObject */
	public ?IDataObject $protoParent;

	/**
	 * Statement runner.
	 * @var IStatementRunner
	 */
	public IStatementRunner $runner;

	public function __construct(IStatementRunner $runner, DBObject $proto, $protoParent = null)
	{
		if (!$protoParent) {
			$protoParent = $proto->parentPrototype();
		}

		$this->proto = $proto;
		$this->protoParent = $protoParent;
		$this->runner = $runner;
	}

	/**
	 * @return IDataObject
	 */
	public function proto()
	{
		return $this->proto;
	}

	/**
	 * @return IDataObject
	 */
	public function protoParent()
	{
		return $this->protoParent;
	}

	/**
	 * @return IStatementRunner
	 */
	protected function database()
	{
		return $this->runner;
	}


	/**
	 * Gets parent object for given object.
	 *
	 * @param IDataObject $obj
	 * @return IDataObject
	 */
	public function getParentObject(IDataObject $obj)
	{
		/** @var DBObject $parent */
		$parent = instance_cast($obj->parentPrototype(), DBObject::class);
		if (IsKPHP::$isUseReflection) {

			$refSrc = ClassRegistry::createReflection(get_class($parent), $obj);
			$refDst = ClassRegistry::createReflection(get_class($parent), $parent);

			foreach (instance_to_array($parent) as $key => $value) {
				/** @var string $name */
				$name = (string)$key;

				if (!$refSrc->isPropertyExists((string)$name)) {
					//object was shortified
					continue;
				}
				if ($obj->isMemberChanged($name)) { //mark only changed columns.
					$parent->setChanged($name);
				}
				$refDst->set_as_mixed($name, $refSrc->get_as_mixed($name)); //clone fields
			}
		}
		else {
#ifndef KPHP
			foreach (instance_to_array($parent) as $name => $value) {
				if (!isset($obj->$name)) {
					//object was shortified
					continue;
				}
				$parent->$name = $obj->$name;
				if ($obj->isMemberChanged((string)$name)) {
					$parent->setChanged((string)$name);
				}
			}
#endif
		}
		return $parent;
	}

	/** Extract base object from given.
	 *
	 * @param IDataObject $obj
	 * @return IDataObject
	 */
	public function getSelfObject(IDataObject $obj):IDataObject
	{
		/** @var IDataObject $object */
		$object =  $obj->createSelf();
		if  (IsKPHP::$isUseReflection) {
			//FIXME: cant create wrong object. verify structure.
			$refSource = ClassRegistry::createReflection(get_class($obj), $obj);
			$refDest = ClassRegistry::createReflection(get_class($obj), $object);

			foreach ($obj->getColumnDefinition() as $def) {
				$name = (string)$def->getAliasOrName();
				$refDest->set_as_mixed($name, $refSource->get_as_mixed($name));
				if ($obj->isMemberChanged($name)) {
					$object->setChanged($name);
				}
			}
		}
		else {
#ifndef KPHP
			foreach ($obj->getColumnDefinition() as $def) {
				$name = $def->getAliasOrName();
				$object->$name = $obj->$name;
				if ($obj->isMemberChanged($name)) {
					$object->setChanged($name);
				}
			}
#endif
		}
		return $object;
	}

	public function insert(IDataObject $obj, ?IDataObject $root = null): int
	{
		if (!$root) {
			$root = $obj;
		}
		if (is_null( $obj->getParentKey())) {
			$insertResult = $this->database()->execute(new SQLStatementInsert($obj));
			$obj->set_primary_key_value($insertResult[0]->get_primary_key_value());
			return $obj->get_primary_key_value();
		}

		$dbo  = instance_cast($obj, DBObject::class);
		if ($dbo->get_parent_key_value() <= 0) {
			$parentObject = $this->getParentObject($obj);
			$dbo->set_parent_key_value($this->insert($parentObject, $root));
			//push value to root object
			$name = (string)$obj->getParentKey()->ownerTag()->getName();
			$root->importValue($name, $parentObject->get_primary_key_value());
		}

		$insertResult = $this->database()->execute(new SQLStatementInsert($obj));
		$obj->set_primary_key_value($insertResult[0]->get_primary_key_value());
		return $obj->get_primary_key_value();
	}

	public function update(IDataObject $obj)
	{
		/** @var DBObject $dbo */
		$dbo = instance_cast($obj, DBObject::class);

		if ($obj->getParentKey() === null) {
			if ($obj->isChanged()) {
				$changedColumns = $dbo->getChangedColumns();
				if ((count($changedColumns) == 1)
						&& array_key_exists($obj->getPrimaryKeyTag()->getName(), $changedColumns)) {
					//changed only PK on the same
					return;
				}
				$this->database()->execute(new SQLStatementUpdate($obj));
			}
			return;
		}

		$this->update($this->getParentObject($obj));

		$self = $this->getSelfObject($obj);

		if ($self->isSelfFieldsChanged()) {
			$this->database()->execute(new SQLStatementUpdate($self));
		}

		foreach ($dbo->getUpdateJoins() as $key) {
			$foreignTag = $key->foreignTag();

			//Get generated object linked with tag.
			//Object filled by data but without PK

			/** @var DBObject $foreignGeneratedObject */
			$foreignGeneratedObject = instance_cast(
				instance_cast($foreignTag, DBColumnDefinition::class)->table, DBObject::class);
			$foreignGeneratedObject->discardChangedState(); //not required because generated

			//select stored object
			$stm = new SQLStatementSelect($foreignGeneratedObject);
			$fkId = (int)$foreignGeneratedObject->getValue((string)$foreignTag->getName());
			$stm->addExpression(new ExprEQ($foreignTag, $fkId));

//			log_info("Joins:Request:". json_encode(instance_to_array($foreignGeneratedObject)));
			/** @var DBObject $storedForeignObject */
			$storedForeignObjects = $this->runner->execute($stm);
			if ( count($storedForeignObjects) > 0 ) {
				$storedForeignObject = instance_cast(array_first_value($storedForeignObjects), DBObject::class);
//				log_info("Joins:found:". json_encode(instance_to_array($storedForeignObject)));
			}
			else {
				$storedForeignObject = null;
			}

			if (!$storedForeignObject) {
				DataSourceLogger::getInstance()->warning("Joins:Foreign object not found for update: "
					. get_class($foreignGeneratedObject) . "({$foreignGeneratedObject->table_name()}): {$foreignTag->getName()}={$fkId}. Creating...");

				$stmInsert = new SQLStatementInsert($foreignGeneratedObject);
				$insertResult = instance_cast($this->runner->execute($stmInsert)[0],DBInsertOneResult::class);
				$foreignGeneratedObject->set_primary_key_value($insertResult->lastId);
			}
			else {
				$copyFields = $foreignGeneratedObject->getColumnDefinition();
				unset($copyFields[(string)$foreignGeneratedObject->getPrimaryKeyTag()->getName()]); //dont export PK to stored object
				$foreignGeneratedObject->copyColumnsTo($storedForeignObject, $copyFields);

//				log_info("Joins:update:". json_encode(instance_to_array($storedForeignObject)));
				if (instance_cast($storedForeignObject, DBObject::class)->isChanged()) {
					Helper::execute(new SQLStatementUpdate($storedForeignObject));
				}
			}
		}

	}

	public function smartUpdate(DBObject $obj)
	{
		if ($obj->isNew()) {
			$this->insert($obj);
		} else {
			$this->update($obj);
		}
	}

	public function delete(DBObject $obj)
	{
		$parent = $this->getParentObject($obj);

		//must be ondelete-cascade - check on generating step!!.
		$this->database()->execute(new SQLStatementDelete($parent));
	}


	/** Get default select
	 * @return SQLStatementSelect
	 */
	public function stmSelect()
	{
		$stm = new SQLStatementSelect($this->proto);

		$parentKey = $this->proto->getParentKey($this->protoParent);
		if (!$parentKey) {
			return $stm;
		}

		$object = $this->proto;
		$parent = $object->parentPrototype();

		while ($parent !== null) {
			/** @var DBForeignKey $parentKey */
			$parentKey = instance_cast($object, DBObject::class)->getParentKey($parent);
			$stm->addJoin(SQLJoin::createByPair($parentKey->ownerTag(), $parentKey->foreignTag()));
			$object = $parent;
			$parent = instance_cast($object, DBObject::class)->parentPrototype();
		}

		$columns = array();
		$stm->resetColumns();
		/** @var DBObject $dbObject */
		$dbObject = instance_cast($stm->object, DBObject::class);
		foreach ($dbObject->getColumnDefinitionExtended($columns) as $def) {
			$stm->addColumn($def);
		}

		foreach ($dbObject->getSelectJoins() as $join) {
			$stm->addJoin($join);
		}
		return $stm;
	}

	public function stmSelectByDetailsId($id)
	{
		if (!is_array($id)) {
			$id = array($id);
		}
		$stm = $this->stmSelect();
		$stm->addExpression(new ExprIN($this->proto()->getPrimaryKeyTag(), $id));
		return $stm;
	}

	public function stmSelectByParentId(int $id):SQLStatementSelect
	{
		$stm = $this->stmSelect();
		$stm->addExpression(new ExprIN($this->protoParent()->getPrimaryKeyTag(), [$id]));
		return $stm;
	}

	public function stmAddJoins(SQLStatementSelect $stm)
	{
		$proto = $this->proto;
		if  (!( $proto instanceof DBObject)) return $stm;
		$parentKey = $proto->getParentKey($this->protoParent);
		if (!$parentKey) {
			return $stm;
		}

		$object = $proto;
		$parent = $object->parentPrototype();

		while ($parent != null) {
			$parentKey = $object->getParentKey($parent);
			$stm->addJoin(SQLJoin::createByPair($parentKey->ownerTag(), $parentKey->foreignTag()));

			/** @var DBObject $object */
			$object = $parent;
			$parent = $object->parentPrototype();
		}
	}
}