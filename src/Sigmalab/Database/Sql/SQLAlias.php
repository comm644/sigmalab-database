<?php

namespace Sigmalab\Database\Sql;

/**
 * SQL:  AS  keyword.
 *
 *  example:   table.column AS alias
 */
class SQLAlias
{
	public ?string $table;
	public string $column = '';
	public string $alias = '';

	public function __construct(?string $table, string $column, string $alias)
	{
		$this->table = $table;
		$this->column = $column;
		$this->alias = $alias;
	}

	public function generate(SQLGenerator $generator)
	{
		$parts = array();
		$sql = $generator->getDictionary();

		if ($this->table) {
			$parts[] = SQLName::genTableName((string)$this->table, $generator);
		}
		if ($this->column != null) {
			$parts[] = $sql->sqlTableColumnSeparator;
			$parts[] = SQLName::genName((string)$this->column, $generator);
		}
		if ($this->alias && ($this->alias !== $this->table)) {
			$parts[] = $sql->sqlAs;
			$parts[] = SQLName::genTableName($this->alias, $generator);
		}
		return (implode(" ", $parts));
	}

	public function generateAlias($generator)
	{
		if ($this->alias) $name = $this->alias;
		else if ($this->column) $name = $this->column;
		else $name = $this->table;
		return (SQLName::genName($name, $generator));
	}
}
