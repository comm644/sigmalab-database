<?php

namespace Sigmalab\Database\Sql;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Expressions\IExpression;

/**
 * This class provides column as result of calculatons.
 * You can use Expr* object as argument.
 */
class SQLColumnExpr implements IDBColumnDefinition

{
	/** @var IExpression */
	public IExpression $expr;

	public ?string $alias;

	/**
	 * @var string
	 */
	public string $type = '';

	public function __construct(IExpression $expr, ?string $alias = null, string $type = "string")
	{
		$this->expr = $expr;
		$this->alias = $alias;
		$this->type = $type;
	}

	public function getAlias(): ?string
	{
		return ($this->alias);
	}

	public function getAliasOrName()
	{
		return $this->getAlias();
	}

	/**
	 * Generate SQL query.
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause
	 * @return string  SQL query
	 */
	public function generate(SQLGenerator $generator, int $cause = 0): string
	{
		$sql = $generator->getDictionary();

		$parts = array();

		$parts[] = SQL::compileWhereExpr($this->expr, $generator);

		if ($this->alias) {
			$parts[] = $sql->sqlAs;
			$parts[] = $generator->generateName(new SQLName(null, $this->alias));
		}
		return (implode(" ", $parts));
	}

	/** @inheritDoc */
	public function getName(): ?string
	{
		return null;
	}

	public function getTableAlias(): ?string
	{
		return $this->getTableName();
	}

	/**
	 * Gets raw table name.
	 *
	 * @return string|null ?string
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

	public function getColumn(): ?string
	{
		return "";
	}

	public function getTable(): ?string
	{
		return null;
	}

	public function __toString(): string
	{
		$expr = str_replace("\n", "\n  ", (string)$this->expr);
		return "(ColumnExpr  type=$this->type alias=$this->alias\n   (expr\n    $expr))";
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
