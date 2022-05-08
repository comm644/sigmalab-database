<?php
/******************************************************************************
 * Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : Database Object base class
 * File       : DBObject.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description: for describing datasets
 ******************************************************************************/

namespace Sigmalab\Database\Core;

use ADO\src\Sigmalab\Database\Core\DBSettings;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Sql\SQLJoin;
use Sigmalab\IsKPHP;
use Sigmalab\SimpleReflection\ClassRegistry;
use Sigmalab\SimpleReflection\ICanReflection;
use Sigmalab\SimpleReflection\PhpReflection;

/** base class for DataObjects/table_definitions
 */
abstract class DBObject
	implements IDataObject, IDBCanSerializeToMixed
{
	/**
	 * @var mixed[]
	 */
	protected array $_changedColumns = [];

	/**
	 * @var bool
	 */
	protected bool $_isChanged = false;

	/**
	 * @var string|null
	 */
	private ?string $_tableAlias = null;

	/**
	 * DBObject constructor.
	 */
	public function __construct()
	{
	}


	/**
	 * Gets table name associated with object.
	 *
	 * @return string  table name
	 */
	public abstract function table_name(): string;

	public function primary_key_value(): int
	{
		$tag = $this->getPrimaryKeyTag();
		return (int)$this->getValue((string)$tag->getName());
	}

	/** returns primary key tag */
	abstract public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition;

	/**
	 * return condition for searching by primary keys if used several PKs
	 *
	 * @return IExpression for searching by primary keys
	 * @throws DatabaseArgumentException
	 */
	public function get_condition(): IExpression
	{

		/** @var DBColumnDefinition[] $pks */
		$pks = array($this->getPrimaryKeyTag());

		$cond = array();

		if (IsKPHP::$isUseReflection) {
			$ref = $this->getReflection();
			foreach ($pks as $keyTag) {
				$name = (string)$keyTag->getName();
				$cond[] = new ExprEQ($keyTag, $ref->get_as_int($name));
			}
		} else {
#ifndef KPHP
			foreach ($pks as $keyTag) {
				$name = (string)$keyTag->getName();
				$cond[] = new ExprEQ($keyTag, (int)$this->{$name});
			}
#endif
		}
		return $cond[0];
//		$cond = new ExprAND($cond);
//
//		return ($cond);
	}

	/** return unique ID  as text combined from several primary keys
	 * @return string  created unique ID as \b string
	 */
	public function get_uid(): string
	{
		$pk = $this->getPrimaryKeyTag()->getName();
		if (!is_array($pk)) $pk = array($pk);

		$ids = array();
		foreach ($pk as $key) {
			$pkval = $this->getValue($key);
			if (is_numeric($pkval)) $pkval = dechex($pkval);
			else if (is_string($pkval)) $pkval = md5($pkval);
			$ids[] = $pkval;
		}
		return (implode("-", $ids));
	}

	/** returns  \a true if object was changed.
	 * @return bool value , \a true if object was changed or \a false
	 */
	public function isChanged(): bool
	{
		if (!isset($this->_isChanged)) return (false);
		return ($this->_isChanged);
	}

	/**
	 * @return mixed[]
	 */
	public function getChangedColumns(): array
	{
		return $this->_changedColumns;
	}

	/**
	 * returns true if object newly created and not stored in database
	 *
	 * @return bool true if newly created
	 */
	public function isNew()
	{

		$val = $this->primary_key_value();
		return (($val === 0) || ($val === -1));
	}

	/** return ASSOC array with new values
	 * @return array associative \b array  of changed columns
	 */
	public function getUpdatedFields()
	{
		if (!isset($this->_changedColumns)) {
			return array();
		}

		$updated = array();
		foreach ($this->_changedColumns as $name => $dummy) {
			$updated[$name] = $dummy;
		}
		return ($updated);
	}

	/** Indicates that any self field has changed.
	 * @return bool
	 */
	public function isSelfFieldsChanged(): bool
	{
		if (!isset($this->_changedColumns)) {
			return false;
		}
		foreach ($this->getColumnDefinition() as $def) {
			if (array_key_exists($def->getName(), $this->_changedColumns)) return true;
		}
		return false;

	}

	/** return Column Definition array
	 * @return IDBColumnDefinition[] items - object relation scheme
	 */
	public function getColumnDefinition(): array
	{
		$ref = ClassRegistry::createReflection(get_class($this), $this);
		$columnDefinition = array();
		foreach (instance_to_array($this) as $name => $value) {
			$sName = (string)$name;
			$columnDefinition[$sName] = new DBColumnDefinition($sName, gettype($ref->get_as_mixed($sName)));
		}
		return ($columnDefinition);
	}

	/**
	 * @param IDBColumnDefinition[] $array
	 * @return IDBColumnDefinition[]
	 */
	protected function indexedDefs(array $array): array
	{
		$result = [];

		foreach ($array as $item) {
			$result[(string)$item->getName()] = $item;
		}
		return $result;
	}

	/** Get column definition for extended object
	 *
	 * @param IDBColumnDefinition[] $columns
	 * @return IDBColumnDefinition[]
	 */
	public function getColumnDefinitionExtended(array &$columns): array
	{
		return $this->getColumnDefinitionExtended_DBObject($columns);
	}

	/** Get column definition for extended object (due fix KPHP bug)
	 *
	 * @param IDBColumnDefinition[] $columns
	 * @return IDBColumnDefinition[]
	 */
	public function getColumnDefinitionExtended_DBObject(array &$columns):array
	{
		$columns = array_merge($columns, $this->getColumnDefinition());

		$parent = $this->parentPrototype();
		if ($parent) {
			$parent->getColumnDefinitionExtended($columns);
		}
		return $columns;
	}

	/** Import value (from sql ) without setting up changed state.
	 * @param string $name
	 * @param mixed $value
	 */
	public function importValue(string $name, $value): void
	{
		if ( DBSettings::$isDiscoverOptimization ){
			DataSourceLogger::getInstance()->warning('Used reflection for '.get_class($this) ."::$name slow because mixed");
		}
		if (IsKPHP::$isUseReflection) {
			//FIXME: implement skip privates on json_encode KPHP
			$ref = $this->getReflection();
			$ref->set_as_mixed($name, $value);
		} else {
#ifndef KPHP
			$this->{$name} = $value;
			if  (property_exists($this, $name)) {
				$this->{$name} = $value; //PHP: 1.3s
			}
			else {
				DataSourceLogger::getInstance()->warning(get_class($this)."::$name not declared in class. skip set value.");
			}
#endif
		}
	}
	/** Import value (from sql )
	 * @param mixed $value
	 */
	public function importValueByKey(int $key, $value) : bool
	{
		return false;
	}

	/** Set property value with setting up changed state.
	 * @param string $name member name
	 * @param mixed $value new member value
	 * @return bool \a true  if new value is equals, or \a false  if member was changed
	 *
	 * @throws DatabaseArgumentException
	 */
	public function setValue(string $name, $value)
	{
		if (IsKPHP::$isUseReflection) {
			$ref = $this->getReflection();
			$previousValue = $ref->get_as_mixed($name);
			if ($previousValue === $value) return true;
			{//setChanged()
				$this->_isChanged = true;
				$this->_changedColumns[$name] = $previousValue;
			}

			$ref->set_as_mixed($name, $value);
			return (false);
		} else {
			$rc = false;
#ifndef KPHP
			$previousValue = $this->$name;
			if ($previousValue === $value) return true;

			{//setChanged()
				$this->_isChanged = true;
				$this->_changedColumns[$name] = $previousValue;
			}

			$this->$name = $value;
			$rc = false;
#endif
		}
		return true;
	}

	/** shows  changed state for selected member
	 * @param string $name member name
	 * @return bool  true when member value was changed
	 */
	public function isMemberChanged(string $name): bool
	{

		if (!$this->isChanged() || !isset($this->_changedColumns)) return (false);
		return (array_key_exists($name, $this->_changedColumns));
	}

	/** get previous value of changed member
	 * @param string $name \b string member name
	 * @return mixed
	 */
	public function getPreviousValue(string $name)
	{
		if (!$this->isMemberChanged($name)) {
			return $this->getValue($name);
		}
		return ($this->_changedColumns[$name]);
	}

	/** revert changed for selected member
	 * set to member previous value , as was before any changes
	 * @param string $name \b string  member name
	 * @return bool
	 */
	public function revertMemberChanges(string $name)
	{
		$ref = ClassRegistry::createReflection(get_class($this), $this);
		if (!$this->isMemberChanged($name)) return (true);

		$ref->set_as_mixed($name, $this->getPreviousValue($name));

		unset($this->_changedColumns[$name]);
		if (count($this->_changedColumns) == 0) {
			$this->_isChanged = false;
		}

		return false;
	}

	/** get value for selected member
	 * @param string $name member name
	 * @return  mixed  member value
	 * @throws DatabaseArgumentException
	 */
	public function getValue(string $name)
	{
		if (IsKPHP::$isUseReflection) {
			return $this->getReflection()->get_as_mixed($name);
		} else {
#ifndef KPHP
			return $this->$name;
#endif
		}
		/** @noinspection PhpUnreachableStatementInspection */
		return 0;
	}

	/** Set object changed state.
	 * @param bool $sign
	 */
	public function setIsChanged(bool $sign)
	{
		$this->_isChanged = true;
	}

	/** Force set state as changed because all changes
	 * can be blocked if new value identical to current
	 * @param string $name member name
	 */
	public function setChanged(string $name): void
	{
		if (IsKPHP::$isUseReflection) {
			$value = $this->getReflection()->get_as_mixed($name);
		} else {
#ifndef KPHP
			$value = $this->$name;
#endif
		}


		$this->_isChanged = true;
		$this->_changedColumns[$name] = $value;
	}


	/**
	 * @param string $name
	 * @param mixed $previousValue
	 */
	public function setChangedValue(string $name, $previousValue)
	{
		$this->_isChanged = true;
		$this->_changedColumns[$name] = $previousValue;
	}

	/** discard changed state
	 *
	 * can be used for hiding from database engine any changes.
	 */
	public function discardChangedState()
	{

		if (!$this->isChanged()) return;
		$this->_isChanged = false;
		$this->_changedColumns = [];
	}

	/** return table alias
	 * @return string  table alias described for object table (ORM bindings)
	 */
	public function getTableAlias(): string
	{

		if (!isset($this->_tableAlias)) return ('');
		return (string)$this->_tableAlias;
	}

	/** set table alias
	 * @param string|null $alias table alias for current object instance (ORM bindings)
	 * @return DBObject
	 */
	public function setTableAlias(?string $alias): self
	{

		$this->_tableAlias = $alias;
		return $this;
	}

	/**
	 * Gets parent object prototype if base class (table) defined.
	 *
	 * @return IDataObject|null
	 */
	public function parentPrototype(): ?IDataObject
	{
		return null;
	}

	/** Gets prototype map for object
	 *
	 * array: table name => DBObject
	 *
	 * @return self[]
	 */
	public function prototypeMap()
	{
		return array();
	}

	/**
	 * Sets parent object UID
	 * @param int $value
	 */
	public function set_parent_key_value(int $value)
	{
	}

	/**
	 * Gets parent object UID
	 */
	public function get_parent_key_value(): ?int
	{
		return 0;
	}

	/** Sets primary key value. */
	public function set_primary_key_value(int $value): void
	{
		$name = $this->getPrimaryKeyTag()->getName();
		$this->importValue((string)$name, $value);
	}

	/**
	 * Gets primary key value.
	 *
	 * @return int
	 */
	public function get_primary_key_value(): int
	{
		return $this->primary_key_value();
	}

	/**
	 * Gets parent class foreign key.
	 * @param IDataObject|null $proto
	 * @return DBForeignKey|null
	 */
	public function getParentKey(?IDataObject $proto = null): ?DBForeignKey
	{
		return null;
	}

	//reflection. routines for changing object properties via inheritance


	/** reset all object fields for inheritance routines and simplyfiyng object
	 * WARNING: Dont't use it in PHP7  mode. Very dangerous operation.
	 * @deprecated
	 */
	public function reflection_resetFields()
	{
//#ifndef KPHP
//		//remove orig fields
//		foreach ($this as $key => $var) {
//			if (method_exists($this, 'tag_' . $key)) {
//				//FIXME: Dont't use it in PHP7  mode. Very dangerous operation.
//				//unset($this->$key);
//			}
//		}
//#endif
	}

	/** Methods provides export object according column specification
	 * @return mixed
	 * @throws DatabaseArgumentException
	 */
	public function serializeToMixed()
	{
		/** @var mixed $fields */
		$fields = [];
		/** @var IDBColumnDefinition[] $columns */
		$columns = [];
		foreach ($this->getColumnDefinitionExtended($columns) as $def) {
			$name = $def->getAliasOrName();
			$fields[(string)$name] = $this->getValue((string)$name);
		}
		return $fields;
	}

	/** Add field to object
	 * @param IDBColumnDefinition $tag
	 */
	public function reflection_addField(IDBColumnDefinition $tag)
	{
		$name = $tag->getAliasOrName();
#ifndef KPHP
		if ($tag->getType() === "string") {
			$this->{$name} = "";
		} else {
			$this->{$name} = 0;
		}
#endif
	}

	/**
	 * Compose object fields according to Database definition.
	 * should be executed from constructor.
	 */
	public function reflection_compose()
	{
		//$this->reflection_resetFields();
		foreach ($this->getColumnDefinition() as $def) {
			$this->reflection_addField($def);
		}
	}

	/**
	 * Gets members of object which ned use like composite
	 * @return array
	 */
	public function members()
	{
		return array();
	}

	/**
	 * @return SQLJoin[]
	 */
	public function getSelectJoins(): array
	{
		return [];
	}

	/**
	 * @return DBForeignKey[]
	 */
	public function getUpdateJoins(): array
	{
		return [];
	}


	private ?ICanReflection $ref = null;

	/**
	 * @return ICanReflection
	 */
	private function getReflection(): ICanReflection
	{
		if ($this->ref) return $this->ref;

		if (IsKPHP::$isUseReflection) {
			return $this->ref = ClassRegistry::createReflectionForInstance($this);
		} else {
#ifndef KPHP
			return $this->ref = new PhpReflection($this);
#endif
		}
		/** @noinspection PhpUnreachableStatementInspection */
		throw new DatabaseArgumentException("Invalid use " . __FUNCTION__);
	}


	/** Convert to array for JSON according to columns specification.
	 * @param IDBColumnDefinition[]|null $defs
	 * @return mixed[]
	 */
	public function toArray(?array $defs = null): array
	{
		$result = [];
		if (!$defs) {
			$columns = $this->getColumnDefinition();
			$defs = $this->getColumnDefinitionExtended($columns);
		}
		foreach ($defs as $def) {
			$result[(string)$def->getAliasOrName()] = $this->getValue((string)$def->getAliasOrName());
		}
		return $result;
	}

	/**  Convert all objects to array for JSON according to columns specification.
	 * @param DBObject[] $objects
	 * @return mixed[]
	 */
	public static function toArrayAll(array $objects): array
	{
		$result = [];
		foreach ($objects as $key => $object) {
			$result[$key] = $object->toArray();
		}
		return $result;
	}

	/** Export columns values to other DBObject.
	 *
	 *
	 * @warning Method copy PK also.
	 * @param DBObject $another
	 * @param IDBColumnDefinition[]|null $copyFields
	 */
	public function copyColumnsTo(DBObject $another, ?array $copyFields = null): void
	{
		$this->copyColumnsTo_DBObject($another, $copyFields);
	}

	/** Export columns values to other DBObject.
	 *
	 * @param DBObject $another
	 * @param IDBColumnDefinition[]|null $copyFields
	 */
	protected function copyColumnsTo_DBObject(DBObject $another, ?array $copyFields = null): void
	{
		if (!$copyFields) {
			$columns = $this->getColumnDefinition();
			$copyFields = $this->getColumnDefinitionExtended($columns);
		}
		foreach ($copyFields as $def) {
			$columnName = (string)$def->getName();
			$another->setValue($columnName, $this->getValue($columnName));
		}
	}

	public function createSelf(): IDataObject
	{
		if ( IsKPHP::$isUseReflection) {
			$newInstance = ClassRegistry::createClass(get_class($this));
			/** @var IDataObject $casted */
			$casted = instance_cast($newInstance, IDataObject::class);
			return $casted;
		}
		else {
#ifndef KPHP
			//create new object instead clone. same way as Reflection.
			$class = get_class($this);
			return new $class;
#endif
		}
		/** @noinspection PhpUnreachableStatementInspection */
		throw new DatabaseArgumentException("Invalid method use");
	}
	/** get column definitions for foreign keys
	 * @return \Sigmalab\Database\Core\DBForeignKey[]
	 */
	public function getForeignKeys() : array
	{
		return [];
	}

}
