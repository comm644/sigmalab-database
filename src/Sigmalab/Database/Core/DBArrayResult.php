<?php

namespace Sigmalab\Database\Core;

/**
 * Class DBArrayObject implements proxy object for
 * retrieving any column from database without creating new classes.
 *
 * Dont use it or serialization!!
 *
 * @package Sigmalab\Database\Relations
 */
class DBArrayResult implements IDataObject
{
	private IDataObject $master;
	/** @var mixed */
	private array $_columns = [];

	/**
	 * DBArrayObject constructor.
	 * @param IDataObject $master
	 */
	public function __construct(IDataObject $master)
	{
		$this->master = $master;
	}

	/**
	 * @inheritDoc
	 */
	public function primary_key_value(): int
	{
		$pkname = $this->master->getPrimaryKeyTag()->getName();
		if  (!isset($this->_columns[$pkname])) return 0;
		return (int)$this->_columns[ $pkname ];
	}

	/**
	 * @inheritDoc
	 */
	public function get_primary_key_value(): int
	{
		return $this->primary_key_value();
	}

	/**
	 * @inheritDoc
	 */
	public function set_primary_key_value(int $value): void
	{
	}

	/** @inheritDoc */
	public function getColumnDefinition(): array
	{
		return $this->master->getColumnDefinition();
	}

	public function getColumnDefinitionExtended(array &$columns): array
	{
		$this->getColumnDefinition();
		return $this->master->getColumnDefinitionExtended($columns);
	}

	/**
	 * @inheritDoc
	 */
	public function table_name(): string
	{
		return $this->master->table_name();
	}

	public function getTableAlias(): string
	{
		return (string)$this->master->getTableAlias();
	}

	/**
	 * @inheritDoc
	 */
	public function importValue(string $name, $value): void
	{
		$this->_columns[$name] = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function setValue(string $name, $value)
	{
		$this->_columns[$name] = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function getValue(string $name)
	{
		return $this->_columns[$name];
	}

	/**
	 * @inheritDoc
	 */
	public function setChanged(string $name): void
	{
	}

	public function createSelf(): IDataObject
	{
		return new self($this->master);
	}

	/**
	 * @inheritDoc
	 */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return $this->master->getPrimaryKeyTag();
	}

	/**
	 * @inheritDoc
	 */
	public function parentPrototype(): ?IDataObject
	{
		return $this->master->parentPrototype();
	}

	/**
	 * @inheritDoc
	 */
	public function getParentKey(?IDataObject $proto = null): ?DBForeignKey
	{
		return $this->master->getParentKey($proto);
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
	public function isMemberChanged(string $name): bool
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function isChanged(): bool
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
		//throw new DatabaseException("not supported method in ".__CLASS__);
		return false;
	}

}