<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDBColumnDefinition;


class SQLGroup implements ICanGenerate
{
	public IDBColumnDefinition $column;

	/**
	 * Construct SQL ORDER operator.
	 *
	 * SQL order render code by next rules:
	 *  - if $column is string - value used as column name for default table.
	 *    And renders next code:  'ORDER BY defaultTable.column'
	 *  - if $column is SQLName  - value used as fully qualified SQL Name.
	 *  - if $column is DBColumnDefinition  - value used as fully qualified column name
	 *    and will be rendered as :  ORDER BY tableName.columnName
	 *
	 *
	 * @param IDBColumnDefinition $column column name
	 */
	public function __construct(IDBColumnDefinition $column)
	{
		$this->set($column);
	}

	public function set(IDBColumnDefinition $column)
	{
		$this->column = $column;
	}

	public function generate(SQLGenerator $generator, ?string $defaultTable = null)
	{
		/** @var DBColumnDefinition $column */
		$column = instance_cast($this->column, DBColumnDefinition::class); //shorten val
		$columnTable = $column->getTableAlias();
		if (!$columnTable) {
			$columnTable = $defaultTable;
		}
		return SQLName::getNameFull($columnTable, $column->name, $generator);
	}
}

