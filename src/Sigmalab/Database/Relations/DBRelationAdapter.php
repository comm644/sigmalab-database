<?php
/******************************************************************************
 * Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : Abstract adapter for suppoerting relations for good formed databases
 * File       : RelationAdapter.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 *
 * TODO:  make template using for 'SelectMembers' query
 ******************************************************************************/

namespace Sigmalab\Database\Relations;

use Sigmalab\Database\Core\DBArrayResult;
use Sigmalab\Database\Core\DBObject;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Core\IDataSource;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\ExprIN;
use Sigmalab\Database\Sql\ICanGenerateOne;
use Sigmalab\Database\Sql\IColumnName;
use Sigmalab\Database\Sql\SQLJoin;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Storage\SimpleStatementRunner;
use Sigmalab\SimpleReflection\IReflectedObject;
use StmHelper;


/** class for makeing relations. dot not use It directly
 */
abstract class DBRelationAdapter implements IReflectedObject
{
	public function __construct()
	{
	}


	/**
	 * @param IDataSource $ds
	 * @return SimpleStatementRunner
	 */
	public function database(IDataSource $ds)
	{
		if (!$ds) {
			throw new DatabaseException("Connection for RelationAdapter does not defined");
		}
		return new SimpleStatementRunner($ds);
	}


	/**
	 * @param IDataObject $object
	 * @return ExprEQ[]
	 * @throws DatabaseArgumentException
	 */
	private function _getValuesArray(IDataObject &$object):array
	{
		//FIXME: rewrite relation adapter to return ForeignKey of object.
		$foreignKeys = $this->getForeignKeys();
		$values = array();

		$tags = $object->getColumnDefinition();

		foreach ($foreignKeys as $name) {
			if  (isset($tags[$name])) {
				$def = $tags[$name];
				$value = $object->getValue((string)$def->getName());;
				$values[] = new ExprEQ($def, (int)$value);
			}
		}
		return ($values);
	}


	/**
	 * Add link to member object
	 *
	 * @param int $objectID owner object primary key ID
	 * @param int $memberID member object primary ID
	 * @param IDataSource $ds
	 * @throws DatabaseException
	 * @throws DatabaseArgumentException
	 */
	public function add(int $objectID, int $memberID, IDataSource $ds)
	{
		$obj = $this->getObject($objectID, $memberID);

		/* validate what entry exists */
		$stm = new SQLStatementSelect(new DBArrayResult($obj));
		$stm->resetColumns();
		StmHelper::stmAddCount($stm);
		$stm->setExpression(new ExprAND($this->_getValuesArray($obj)));

		/** @var DBArrayResult $resultCount */
		$resultCount = instance_cast($this->database($ds)->executeSelectOne($stm), DBArrayResult::class);
		/** @noinspection NullPointerExceptionInspection */
		$count = $resultCount->getValue('count' );

		if ($count == 0) {
			$objNew = $this->getObject($objectID, $memberID);
			$this->database($ds)->execute(new SQLStatementInsert($objNew));
		}
	}

	/**
	 * Remove  link to member object
	 *
	 * @param int $objectID owner object primary key ID
	 * @param int $memberID member object primary ID
	 * @param IDataSource $ds
	 * @return array|DBObject|int
	 * @internal param \DBDataSource $ds Data source
	 */
	public function remove(int $objectID, int $memberID, IDataSource $ds)
	{
		$obj = $this->getObject($objectID, $memberID);
		$objectKeys = $obj->getForeignKeys();

		$pairs = array();
		foreach ($this->getForeignKeys() as $keyname) {
			$value = null;
			$key = $objectKeys[$keyname];
			$value = $obj->getValue((string)$key->ownerTag->getName());
			$pairs[] = new ExprEQ($key->ownerTag, (int)$value);
		}
		$expr = new ExprAND($pairs);

		$link = $this->getObject(0, 0);
		$stm = new SQLStatementDelete($link);
		$stm->setExpression($expr);

		return $this->database($ds)->execute($stm);
	}

	/**
	 * Add and remove links
	 *
	 * @param int $objectId owner object ID
	 * @param int[] $addedIds added child IDs
	 * @param int[] $removedIds removed child IDs
	 * @param IDataSource $ds
	 * @throws DatabaseException
	 * @throws DatabaseArgumentException
	 */
	public function addremove(int $objectId, array $addedIds, array $removedIds, IDataSource $ds)
	{
		foreach ($removedIds as $id) {
			$this->remove($objectId, $id, $ds);
		}
		foreach ($addedIds as $id) {
			$this->add($objectId, $id, $ds);
		}
	}

	/** select members by ID/IDs
	 * @param int $objectId
	 * @param IDataSource $ds
	 * @param string $order - sort order
	 * @return array|DBObject|int
	 * @throws DatabaseException
	 */
	public function select(int $objectId, IDataSource $ds, string $order = "")
	{
		$stm = $this->stmSelectChildren([$objectId], $order ? new SQLName(null, $order) : null);
		return $this->database($ds)->execute($stm);
	}

	/**
	 * GGets Statement for selecting child bojects.
	 *
	 * @param int[] $parentIds parent object IDs.
	 * @param IColumnName $order
	 * @return SQLStatementSelect
	 */
	public function stmSelectChildren(array $parentIds, IColumnName $order = null):SQLStatementSelect
	{

		$link = $this->getObject((int)$parentIds[0], 0);
		$data = $this->getDataObject($parentIds[0]);
		$member = $this->getMemberObject(0);

		$defs = $link->getColumnDefinition();
		$keyDefs = array();
		$keys = $this->getForeignKeys();
		foreach ($keys as $key) {
			$keyDefs[] = $defs[$key];
		}


		$linkTable = $link->table_name();
		$memberTable = $member->table_name();

		$dataKey = $data->getPrimaryKeyTag();
		$memberKey = $member->getPrimaryKeyTag();

		$stm = new SQLStatementSelect($member);
		$stm->addJoin(SQLJoin::createByPair($memberKey, $keyDefs[1]));
		$stm->setExpression(new ExprIN($keyDefs[0], $parentIds));

		if ($order) {
			/** @noinspection PhpParamsInspection */
			$stm->addOrder(instance_cast($order, ICanGenerateOne::class));
		}
		return ($stm);
	}

	/**
	 * Get member by ID.
	 *
	 * @param $memberID  int  member PK id.
	 * @param IDataSource $ds
	 * @return IDataObject
	 * @throws DatabaseException
	 * @internal param \IDataSource $ds data source.
	 */
	public function getMemberById(int $memberID, IDataSource $ds)
	{
		$stm = StmHelper::stmSelectByPrimaryKey($this->getMemberObject(0), $memberID);
		return ($this->database($ds)->executeSelectOne($stm));
	}


	/** should be defined in inherits
	 */
	/**
	 * Method must returns instance (prototype) of link object assigned foreign keys
	 * @param int $objectId primary key ID of owner object
	 * @param int $memberId primary key ID of member object
	 * @return DBObject  created link object prototype
	 */
	abstract protected function getObject(int $objectId, int $memberId);

	/**
	 * Method must returns instance (prototype) of member object with assigned primary key ID
	 * @param int $memberId primary key ID
	 * @return DBObject  created object prtotype
	 */
	abstract protected function getMemberObject(int $memberId): DBObject;

	/**
	 * Method must returns instance (prototype) of Owner object with assigned primary key ID
	 * @param int $objectId
	 * @return DBObject  created object prototype
	 */
	abstract protected function getDataObject(int $objectId): DBObject;

	/**
	 *  Gets names of foreign keys.
	 *
	 * @return array(string)
	 */
	abstract protected function getForeignKeys();


}

