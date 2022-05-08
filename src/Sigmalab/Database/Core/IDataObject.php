<?php


namespace Sigmalab\Database\Core;

use Sigmalab\SimpleReflection\IReflectedObject;

interface IDataObject extends IObjectChanged, IDataHandle, IReflectedObject
{
	/**
	 * returns true if object newly created and not stored in database
	 *
	 * @return bool true if newly created
	 */
	public function isNew();

	/**
	 * @return int
	 */
	public function primary_key_value(): int;

	/** Sets primary key value. */
	public function set_primary_key_value(int $value): void;

	/**
	 * Gets primary key value.
	 *
	 * @return int
	 */
	public function get_primary_key_value(): int;

	/** Get columns
	 * @return IDBColumnDefinition[]
	 */
	public function getColumnDefinition(): array;

	/** Get column definition for extended object
	 *
	 * @param IDBColumnDefinition[] $columns
	 * @return IDBColumnDefinition[]
	 */
	public function getColumnDefinitionExtended(array &$columns): array;


	/** Get table name
	 * @return string
	 */
	public function table_name(): string;

	/** Gets table alias
	 * @return string|null
	 */
	public function getTableAlias(): string;

	/** Import value (from sql )
	 * @param string $name
	 * @param mixed $value
	 */
	public function importValue(string $name, $value) :void;


	/** Import value (from sql ) by key (faster method)
	 * @param mixed $value
	 */
	public function importValueByKey(int $key, $value) : bool;

	/** set property value with state control
	 * @param string $name member name
	 * @param mixed $value new member value
	 * @return bool \a true  if new value is equals, or \a false  if member was changed
	 * */
	public function setValue(string $name, $value);

	/** Get value
	 * @param string $name
	 * @return mixed
	 */
	public function getValue(string $name);

	/** Force set state as changed because all changes
	 * can be blocked if new value identical to current
	 * @param string $name member name
	 */
	public function setChanged(string $name):void;

	public function createSelf(): IDataObject;

	/** returns primary key tag */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition;

	/**
	 * Gets parent object prototype if base class (table) defined.
	 *
	 * @return IDataObject|null
	 */
	public function parentPrototype() :?IDataObject;

	/**
	 * Gets parent class foreign key.
	 * @param IDataObject|null $proto
	 * @return DBForeignKey|null
	 */
	public function getParentKey(?IDataObject $proto = null) : ?DBForeignKey;

	/** Indicates that any self field has changed.
	 * @return bool
	 */
	public function isSelfFieldsChanged():bool;
}
