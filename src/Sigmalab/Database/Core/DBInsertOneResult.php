<?php

namespace Sigmalab\Database\Core;

/**
 * Class DBRowsAffectedResult provides 'rowsAffected' result from query.
 * @package Sigmalab\Database\Core
 */
class DBInsertOneResult implements IDataObject
{
	/**
	 * DBRowsAffectedResult constructor.
	 * @param int $lastId
	 */
	public function __construct(int $lastId=0)
	{
		$this->lastId = $lastId;
	}

	/**
	 * @inheritDoc
	 */
	public function primary_key_value(): int
	{
		return $this->get_primary_key_value();
	}

	/** Get columns
	 * @return \Sigmalab\Database\Core\DBColumnDefinition[]
	 */
	public function getColumnDefinition(): array
	{
		return [];
	}

	public function getColumnDefinitionExtended(array &$columns): array
	{
		return [];
	}

	/**
	 * @inheritDoc
	 */
	public function table_name(): string
	{
		return "";
	}

	/** Gets table alias
	 * @return string
	 */
	public function getTableAlias(): string
	{
		return "";
	}

	/** set property value with state control
	 * @param string $name member name
	 * @param mixed $value new member value
	 * @return bool \a true  if new value is equals, or \a false  if member was changed
	 * */
	public function setValue(string $name, $value)
	{
		return true;
	}

	/** shows  changed state for selected member
	 * @param string $name member name
	 * @return bool  true when member value was changed
	 */
	public function isMemberChanged(string $name): bool
	{
		return false;
	}

	/**
	 * @return  bool
	 */
	public function isChanged(): bool
	{
		return false;
	}

	public int $lastId;

	/**
	 * @inheritDoc
	 */
	public function getValue(string $name)
	{
		return $this->lastId;
	}

	/**
	 * @inheritDoc
	 */
	public function setChanged(string $name): void
	{
		// TODO: Implement setChanged() method.
	}

	public function createSelf(): \Sigmalab\Database\Core\IDataObject
	{
		return new self();
	}

	/**
	 * @inheritDoc
	 */
	public function set_primary_key_value(int $value): void
	{
		// TODO: Implement set_primary_key_value() method.
	}

	/**
	 * @inheritDoc
	 */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return new DBColumnDefinition();
	}

	/**
	 * @inheritDoc
	 */
	public function importValue(string $name, $value): void
	{
		$this->lastId = (int)$value;
	}

	/**
	 * @inheritDoc
	 */
	public function get_primary_key_value(): int
	{
		return $this->lastId;;
	}

	/**
	 * @inheritDoc
	 */
	public function parentPrototype(): ?IDataObject
	{
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getParentKey(?IDataObject $proto = null): ?DBForeignKey
	{
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function isSelfFieldsChanged(): bool
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function isNew()
	{
		return false;
	}

	public function importValueByKey(int $key, $value): bool
	{
		return false;
	}
}