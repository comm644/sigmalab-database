<?php


namespace Sigmalab\Database\Core;


use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Sql\SQLJoin;
use Sigmalab\SimpleReflection\ClassRegistry;

trait DBObjectProps
{
	/**
	 * @var mixed[]
	 */
	private array $_changedColumns = [];

	/**
	 * @var bool
	 */
	private bool $_isChanged = false;

	/**
	 * @var string|null
	 */
	private ?string $_tableAlias = null;

	/** returns primary key tag */
	abstract public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition;

	/**
	 * return condition for searching by primary keys if used sevaral PKs
	 *
	 * @return  IExpression for searching by primary keys
	 */
	public function get_condition()
	{

		$pk = (string)$this->getPrimaryKeyTag()->getName();
		if (!is_array($pk)) $pk = array($pk);

		$cond = array();

		$ref = $this->getReflection();
		foreach ($pk as $key) {

			$cond[] = new ExprEQ($key, $ref->get_as_int($key));
		}
		$cond = new ExprAND($cond);

		return ($cond);
	}

	/** return unique ID  as text combined from several primary keys
	 * @return string  created unique ID as \b string
	 */
	public function get_uid(): string
	{

		$pk = $this->getPrimaryKeyTag()->getName()();
		if (!is_array($pk)) $pk = array($pk);

		$ids[] = array();
		$ref = $this->getReflection();
		foreach ($pk as $key) {
			$pkval = $ref->get_as_int($key);
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
	public function isSelfFieldsChanged()
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
	 * @return DBColumnDefinition[] items - object relation scheme
	 */
	public function getColumnDefinition(): array
	{
		$ref = ClassRegistry::createReflection(get_class($this), $this);
		$columnDefinition = array();
		foreach (instance_to_array($this) as $name => $value) {
			$columnDefinition[$name] = new DBColumnDefinition($name, gettype($ref->get_as_mixed($name)));
		}
		return ($columnDefinition);
	}

	/** Get column definition for extended object
	 *
	 * @param DBColumnDefinition[] $columns
	 * @return DBColumnDefinition[]
	 */
	public function getColumnDefinitionExtended(array &$columns): array
	{
		$columns = array_merge($columns, $this->getColumnDefinition());

		$parent = $this->parentPrototype();
		if ($parent) {
			$parent->getColumnDefinitionExtended($columns);
		}
		return $columns;
	}

	/** set property value with state control
	 * @param string $name member name
	 * @param mixed $value new member value
	 * @return bool \a true  if new value is equals, or \a false  if member was changed
	 * */
	public function setValue(string $name, $value)
	{
		$ref = $this->getReflection();
		if ($ref->get_as_mixed($name) === $value) return (true);
		$this->setChanged($name);
		$ref->set_as_mixed($name,  $value);
		return (false);
	}

	/** shows  changed state for selected member
	 * @param string $name member name
	 * @return bool  true when member value was changed
	 */
	public function isMemberChanged(string $name)
	{

		if (!$this->isChanged() || !isset($this->_changedColumns)) return (false);
		return (array_key_exists($name, $this->_changedColumns));
	}

	/** get previous value of changed member
	 * @param string $name \b string member name
	 */
	public function getPreviousValue(string $name)
	{

		if (!$this->isMemberChanged($name)) return $this->getReflection()->get_as_mixed($name);
		return ($this->_changedColumns[$name]);
	}

	/** revert changed for selected member
	 * set to member previous value , as was before any changes
	 * @param string $name \b string  member name
	 */
	public function revertMemberChanges(string $name)
	{
		$ref = ClassRegistry::createReflection(get_class($this), $this);
		if (!$this->isMemberChanged($name)) return (true);

		$ref->set_as_mixed($this->getPreviousValue($name));

		unset($this->_changedColumns[$name]);
		if (count($this->_changedColumns) == 0) {
			$this->_isChanged = false;
		}

		return false;
	}

	/** get value for selected member
	 * @param string $name member name
	 * @return  mixed  member value
	 */
	public function getValue(string $name)
	{
		return $this->getReflection()->get_as_mixed($name);
	}

	/** Force set state as changed because all changes
	 * can be blocked if new value identical to current
	 * @param string $name member name
	 */
	public function setChanged(string $name)
	{

		$this->_isChanged = true;
		$this->_changedColumns[$name] = $this->getReflection()->get_as_mixed($name);
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

		if (!isset($this->_tableAlias)) return ("");
		return (string)$this->_tableAlias;
	}

	/** set table alias
	 * @param string $alias table alias for current object instance (ORM bindings)
	 */
	public function setTableAlias(?string $alias)
	{

		$this->_tableAlias = $alias;
		return $this;
	}

	/**
	 * Gets parent object prototype if base class (table) defined.
	 *
	 * @return \Sigmalab\Database\Core\IDataObject|null
	 */
	public function parentPrototype()
	{
		return NULL;
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
	 * @param mixed $value
	 */
	public function set_parent_key_value( $value)
	{
	}

	/**
	 * Gets parent object UID
	 * @return mixed
	 */
	public function get_parent_key_value()
	{
		return 0;
	}

	/**
	 * Sets primary key value.
	 *
	 * @param mixed $value
	 */
	public function set_primary_key_value($value)
	{
		;
		$name = $this->getPrimaryKeyTag()->getName();
		$this->getReflection()->set_as_mixed($name, $value);
	}

	/**
	 * Gets primary key value.
	 *
	 * @return mixed
	 */
	public function get_primary_key_value()
	{
		$name = $this->getPrimaryKeyTag()->getName();
		return $this->getValue($name);
	}

	/**
	 * Gets parent class foreign key.
	 * @param \Sigmalab\Database\Core\IDataObject|null $proto
	 * @return \Sigmalab\Database\Core\DBForeignKey
	 */
	public function getParentKey(?\Sigmalab\Database\Core\IDataObject $proto = null)
	{
		return NULL;
	}

	//reflection. routines for changing object properties via inheritance


	/** reset all object fields for inheritance routines and simplyfiyng object
	 */
	public function reflection_resetFields()
	{
#ifndef KPHP
		//remove orig fields
		foreach ($this as $key => $var) {
			if (method_exists($this, 'tag_' . $key)) {
				unset($this->$key);
			}
		}
#endif
	}

	/** Add field to object
	 * @param \Sigmalab\Database\Core\DBColumnDefinition $tag
	 */
	public function reflection_addField(DBColumnDefinition $tag)
	{
		$name = $tag->getAliasOrName();
#ifndef KPHP
		if ($tag->getType() == "string") {
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
		$this->reflection_resetFields();
		foreach ($this->getColumnDefinition() as $def) {
			$this->reflection_addField($def);
		}
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

	/**
	 * @return \Sigmalab\SimpleReflection\ICanReflection
	 */
	private function getReflection(): \Sigmalab\SimpleReflection\ICanReflection
	{
		return $ref = ClassRegistry::createReflection(get_class($this), $this);
	}
}