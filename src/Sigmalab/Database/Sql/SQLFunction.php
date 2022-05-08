<?php
declare(strict_types=1);

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Discovery\SqlPrint;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\IExpression;

require_once(__DIR__ . "/SQLGenerator.php");
require_once(__DIR__ . "/../Core/DBValueType.php");

class SQLFunction implements IDBColumnDefinition
{
	public string $name = '';
	/**
	 * @var ICanGenerateOne[]
	 */
	public array $args = array();
	public ?string $alias = null;
	public string $type = 'string';
	public string $argsGlue = ', ';
	private bool $isAggregated = false;

	/**
	 * Create function definition
	 *
	 * @param string $functionName
	 * @param ICanGenerateOne|null $column
	 * @param string $type result type DBValueType
	 * @param string|null $alias column alias
	 * @return SQLFunction  created object
	 */
	public static function create(string $functionName, ?ICanGenerateOne $column, string $type, ?string $alias = null)
	{
		if (is_null($alias)) {
			$alias = $functionName;
		}
		$obj = new SQLFunction;
		$obj->name = $functionName;
		if ($column) {
			$obj->args[] = $column;
		}
		$obj->alias = $alias;
		$obj->type = $type;

		return ($obj);
	}

	public function getAlias(): ?string
	{
		if ($this->alias === null) return ($this->name);
		return ($this->alias);
	}

	public function getAliasOrName()
	{
		if (is_null($this->getAlias())) {
			throw new DatabaseArgumentException("SQLFunction must have alias");
		}
		return $this->getAlias();
	}

	/**
	 * create function 'count'
	 *
	 * @param string|null $alias (null if not set)
	 * @return SQLFunction
	 */
	public static function count(IDBColumnDefinition  $column, ?string $alias = null)
	{
		if (!$alias) {
			$alias = $column->getAliasOrName();
		}
		return (SQLFunction::create("count", $column, DBValueType::Integer, $alias));
	}

	public static function max(IDBColumnDefinition $column, ?string $alias = null, string $type = DBValueType::Float)
	{
		if (!$type) {
			if ($column instanceof DBColumnDefinition) {
				$type = (string)$column->getType();
			} else {
				$type = DBValueType::Integer;
			}
		}
		if (!$alias) {
			$alias = $column->getAliasOrName();
		}

		$function = SQLFunction::create("max", $column, $type, $alias);
		$function->setIsAggregated(true);
		return ($function);
	}

	public static function min(IDBColumnDefinition $column, ?string $alias = null, $type = DBValueType::Float)
	{
		if (!$type) {
			if ($column instanceof DBColumnDefinition) {
				$type = (string)$column->getType();
			} else {
				$type = DBValueType::Integer;
			}
		}
		if (!$alias) {
			$alias = $column->getAliasOrName();
		}

		$function = SQLFunction::create("min", $column, $type, $alias);
		$function->setIsAggregated(true);
		return ($function);
	}

	public static function sum(
		ICanGenerateOne  $column, ?string $alias = null, string $type = DBValueType::Float):SQLFunction
	{
		return (SQLFunction::create("sum", $column, $type, $alias));
	}

	/** Generate CAST expression
	 * @param DBColumnDefinition|SQLFunction $column
	 * @param string $type DBValueType enum
	 * @return SQLFunction
	 */
	public static function cast($column, $type)
	{
		return self::create("", $column, $type);
	}

	/**
	 * @param string $name
	 * @param array $args
	 * @param string $alias
	 * @param string $type
	 * @return SQLFunction
	 */
	public static function custom(string $name, array $args, string $alias, string $type): SQLFunction
	{
		$func = SQLFunction::create($name, null, $type, $alias);
		$func->args = array_map(function ($expr) {
			return instance_cast($expr, ICanGenerateOne::class);
		}, $args);
		$func->argsGlue = ', ';
		return ($func);
	}

	/**
	 * Generate SQL query.
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause
	 * @return string  SQL query
	 * @throws \Exception
	 */
	public function generate(SQLGenerator $generator, int $cause = 0): string
	{
		$sql = $generator->getDictionary();

		if ($cause === DBGenCause::Order) {
			$alias = $this->alias;
			return $generator->generateName(new SQLName(null, $alias));
		}

		/** @var string[] $parts */
		$parts = array();

		$isCast = $generator->generateTypeCastTo($this->type);

		$parts[] = $this->name . $sql->sqlOpenFuncParams;
		$pos = 0;
		$canCast = (count($this->args) === 1)
			&& ($this->type === DBValueType::Integer)
			&& ($this->type === DBValueType::Real);
		$isCast = $isCast && $canCast;

		if ($isCast) {
			$parts[] = $sql->sqlCast;
			$parts[] = $sql->sqlOpenFuncParams;
		}

		foreach ($this->args as $arg) {
			if ($pos > 0) $parts[] = $this->argsGlue;
			if ($arg instanceof IDBColumnDefinition) {
				$c1 = instance_cast($arg, IDBColumnDefinition::class);
			}
			if ($arg instanceof ICanGenerateOne) {
				/** @var ICanGenerateOne $column1 */
				$column1 = instance_cast($arg, ICanGenerateOne::class);
				$parts[] = $generator->generateColumn($column1, $this->getTableAlias());
			}
#ifndef KPHP
			else if ($arg instanceof SQLValue) {
				$parts[] = $arg->compileExpression(new ECompilerSQL($generator, false));
			} else if ($arg instanceof IExpression) {
				$parts[] = $arg->generate($generator);
			}
#endif
			else if (is_object($arg)) {
				throw new \Exception("Invalid argument type in SQLFunction (no an instance of ICanGenerateOne");
			}
#ifndef KPHP
			else if (is_scalar($arg)) {
				$parts[] = (string)$arg;
			}
#endif
			else {
				throw new \Exception("Invalid argument type in SQLFunction (no an instance of ICanGenerateOne");
			}
			$pos++;
		}
		if ($isCast) {
			$parts[] = $generator->generateTypeCastTo($this->type);
			$parts[] = $sql->sqlCloseFuncParams;
		}

		$parts[] = $sql->sqlCloseFuncParams;


		$alias = $this->alias;
		$column = $this->args[0];
		if (!$alias && ($column instanceof IDBColumnDefinition) && ($cause === DBGenCause::Columns)) {
			/** @var IDBColumnDefinition $col */
			$col = instance_cast($column, IDBColumnDefinition::class);
			//only for COLUMNS
			$alias = $col->getName();
		}
		if ($alias) {

			$parts[] = $sql->sqlAs;
			$parts[] = $generator->generateName(new SQLName(null, $alias));
		}
		return (implode(" ", $parts));
	}

	/**
	 * Gets column name. Methods retuns raw column name.
	 *
	 * @return string
	 */
	public function getName(): ?string
	{
		$aliasOrName = $this->getAliasOrName();
		if (is_null($aliasOrName)) throw  new DatabaseArgumentException("Invalid use:" . __FUNCTION__);

		return $aliasOrName;
	}

	/**
	 * Gets table alias.
	 * Method returns table alias if alias defined. If table alias is not defined
	 * then method returns table name.
	 *
	 * If table not defined for column then method returns null
	 *
	 * @return string|null ?string  table alias
	 */
	public function getTableAlias(): ?string
	{
		$tableName = $this->getTableName();
		if (!$tableName) return "";
		return (string)$tableName;
	}

	/**
	 * Gets raw table name.
	 *
	 * @return string|null
	 */
	public function getTableName(): ?string
	{
		return null;
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

	public function __toString(): string
	{
		/** @var IExpression[] $args */
		$args = array_map(function ($def) {
			return new SQLValue(SqlPrint::indent(SqlPrint::call("funcArg", [$def])));
		}, $this->args);

		return SqlPrint::call("Func name=$this->name  type=$this->type alias=$this->alias argsCount="
			. count($this->args), $args);
	}


	public function getSqlName():SQLName
	{
		return new SQLName(null, $this->alias, $this->type);
	}

	private function setIsAggregated(bool $isAggregated)
	{
		$this->isAggregated = $isAggregated;
	}

	/**
	 * @inheritDoc
	 */
	public function isAggregated(): bool
	{
		return $this->isAggregated;
	}

	public function columnKey(): int
	{
		return 0;
	}
}
