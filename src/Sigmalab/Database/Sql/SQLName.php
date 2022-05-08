<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Discovery\SqlPrint;
use Sigmalab\Database\Expressions\IExpression;


class SQLName implements IColumnName,
	IDBColumnDefinition
{
	public ?string $table;
	public ?string $column;
	/**
	 * @var string
	 */
	private string $type;

	public function __construct(?string $table,?string $column, string $type=DBValueType::Integer)
	{
		$this->table = $table;
		$this->column = $column;
		$this->type = $type;

	}

	/** returns normalized escaped NAME for SQL
	 *
	 * sample:
	 * in:  table.name
	 * out: `table`.`name`
	 * @param string $name
	 * @param SQLGenerator $generator
	 * @return string
	 * @throws DatabaseArgumentException
	 */
	public static function genName(string $name, SQLGenerator $generator)
	{
		$sql = $generator->getDictionary();

		$pos = strpos($name, $sql->sqlTableColumnSeparator);
		if ($pos !== FALSE) {
			$table = substr($name, 0, $pos);
			$column = substr($name, $pos + 1);
			if  ($table === false ) throw new DatabaseArgumentException("Invalid table name");
			if  ($column === false ) throw new DatabaseArgumentException("Invalid column name");

			$obj = new SQLName((string)$table, $column);
		} else {
			$obj = new SQLName(null, $name);

		}
		return $obj->generate($generator);
	}


	public static function genTableName(string $name, SQLGenerator $generator):string
	{
		return (new SQLName($name, null))->generate($generator);
	}

	/**
	 * @param string|null $table
	 * @param string|null $column
	 * @param SQLGenerator $generator
	 * @return string
	 * @throws DatabaseArgumentException
	 */
	public static function getNameFull(?string $table, ?string $column, SQLGenerator $generator)
	{
		$sql = $generator->getDictionary();

		if (!$table) return SQLName::wrap((string)$column, $sql);

		return (SQLName::wrapTableName((string)$table, $sql)
			. $sql->sqlTableColumnSeparator . SQLName::wrap((string)$column, $sql));
	}

	public static function wrap(string $name, SQLDic $sql)
	{
		if (!$sql->sqlOpenName) {
			return $name;
		}
		if (strpos($name, $sql->sqlOpenName) !== FALSE) {
			throw  new DatabaseArgumentException('Invalid argument: $name' . "\nSQL Name cannot be given with quotes, because ADO database independed.");
		}
		$name = $sql->sqlOpenName . $name . $sql->sqlCloseName;

		return ($name);
	}

	/**
	 * @param string $name
	 * @param SQLDic $sql
	 * @return string
	 * @throws DatabaseArgumentException
	 */
	public static function wrapTableName(string $name, SQLDic $sql):string
	{

		if (!$sql->sqlOpenTableName) {
			return $name;
		}
		if (strpos($name, $sql->sqlOpenTableName) !== FALSE) {
			throw new DatabaseArgumentException('Invalid argument: $name' . "\nSQL Name cannot be given with quotes, because ADO database independed.");
		}
		$name = $sql->sqlOpenTableName . $name . $sql->sqlCloseTableName;

		return ($name);
	}

	/**
	 * Generate SQL query.
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause
	 * @return string  SQL query
	 * @throws DatabaseArgumentException
	 */
	public function generate(SQLGenerator $generator, int $cause=0):string
	{
		$sql = $generator->getDictionary();

		if ($this->table != null) {
			$tableName = SQLName::wrapTableName((string)$this->table, $sql);
			if ($this->column != null) {
				return $tableName . $sql->sqlTableColumnSeparator . SQLName::wrap((string)$this->column, $sql);
			}
			return $tableName;
		}
		if ($this->column != null) {
			return SQLName::wrap((string)$this->column, $sql);
		}

		return ('');
	}

	public function getColumn(): ?string
	{
		return $this->column;
	}

	public function getTable(): ?string
	{
		return $this->table;
	}

	/**
	 * @inheritDoc
	 */
	public function getAlias(): ?string
	{
		return $this->column;
	}

	/**
	 * @inheritDoc
	 */
	public function getAliasOrName()
	{
		return $this->column;
	}

	/**
	 * @inheritDoc
	 */
	public function getTableAlias(): ?string
	{
		return $this->getTable();
	}

	public function equals(IDBColumnDefinition $tag)
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function isNullable()
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function getType()
	{
		return $this->type;
	}

	/** @inheritDoc */
	public function getName(): ?string
	{
		return $this->column;
	}

	/**
	 * @inheritDoc
	 */
	public function getTableName(): ?string
	{
		return $this->table;
	}

	public function __toString(): string
	{
		return $this->toString();
	}
	public function toString():string
	{
		/** @var IExpression[] $args */
		$args = [];
		return SqlPrint::call("SQLName: table={$this->table} column={$this->column} type={$this->type}", $args);
	}

	/**
	 * @inheritDoc
	 */
	public function isAggregated(): bool
	{
		return false;
	}

	public function columnKey(): int
	{
		return 0;
	}
}
