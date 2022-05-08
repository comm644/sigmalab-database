<?php

namespace Sigmalab\Database\Sql;
use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBObject;
use Sigmalab\Database\Core\IDataObject;

/** DOc not use this class. required only for creating type info */
class DBObjectMock extends DBObject
{
	/**
	 * @return DBColumnDefinition[]
	 */
	public function getColumnDefinition(): array
	{
		return array();
	}

	public function table_name(): string
	{
		return "";
	}

	public function createSelf(): IDataObject
	{
		return new self();
	}

	/**
	 * @inheritDoc
	 */
	public function getPrimaryKeyTag(): \Sigmalab\Database\Core\IDBColumnDefinition
	{
		return new DBColumnDefinition("key");
	}
}