<?php

namespace Sigmalab\Database\Sql;

use Exception;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\IExpression;

class SQLStatementDelete extends SQLStatementChange
{
	public ?IExpression $expr = null;

	public function __construct(IDataObject $obj)
	{
		parent::__construct($obj);
		$this->sqlStatement =  "DELETE FROM";
		if ($obj instanceof DBObjectMock) {
			return;
		}

		if (($obj->primary_key_value() == 0) || ($obj->primary_key_value() == -1)) {
			return;
		}
		$this->setExpression(new ExprEQ($obj->getPrimaryKeyTag(), $obj->primary_key_value()));
	}

	/**
	 *  Set WHERE expression directly.
	 *
	 * @param $expr  IExpression object defined condition
	 * @return self
	 */
	public function setExpression(IExpression $expr) :self
	{
		$this->expr = $expr;
		return $this;
	}

	/**
	 * Add WHERE expression with AND clause or set expression
	 * if was empty not exists.
	 *
	 * @param $expr  IExpression object defined condition
	 * @return  self
	 * @throws \Sigmalab\Database\DatabaseArgumentException
	 */
	public function addExpression(IExpression $expr) :self
	{
		if ($this->expr !== null) {
			$this->expr = new ExprAND([$this->expr, $expr]);
		} else {
			$this->setExpression($expr);
		}
		return $this;
	}

	public function generate(SQLGenerator $generator, int $mode = 0): string
	{
		if ($this->object->getTableAlias() != null) {
			throw new Exception('Aliases for SQL DELETE does not supported. Check prototype.');
		}
		if (!$this->table) {
			throw new DatabaseArgumentException('Table not defined SQL DELETE does not supported. Check prototype.');
		}
		$parts = array();
		$parts[] = $this->sqlStatement;

		$parts[] = SQLName::genTableName((string)$this->table, $generator);
		if ((is_array($this->expr) && (count($this->expr) != 0)) || ($this->expr !== null)) {
			$parts[] = $this->sqlWhere;
			$parts[] = SQL::compileWhereExpr($this->expr, $generator);
		}

		return (implode(" ", $parts));
	}
}
