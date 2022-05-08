<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBObject;
use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\IExpression;

class SQLStatementUpdate extends SQLStatementChange
{
	public bool $signForceUpdate = false;
	public ?IExpression $expr = null;


	public function __construct(IDataObject $obj)
	{
		parent::__construct($obj);
		$this->sqlStatement = "UPDATE";
	}

	public function generate(SQLGenerator $generator, int $mode = 0): string
	{
		$parts = array();
		$parts[] = parent::generate($generator);
		$parts[] = $this->sqlWhere;
		$parts[] = $this->getCondition($generator);
		if ($generator->updateLimitEnabled()) {
			$parts[] = $this->sqlLimit;
			$parts[] = SQLValue::getValue(1, DBValueType::Integer, $generator);
		}

		return (implode(" ", $parts));
	}

	public function _generateParametrizedQuery(array $names, array $pholders, \Sigmalab\Database\Sql\SQLGenerator $generator): string
	{
		$parts = array();
		$parts[] = parent::_generateParametrizedQuery($names, $pholders, $generator);
		$parts[] = $this->sqlWhere;
		$parts[] = $this->getCondition($generator);

		if ($generator->updateLimitEnabled()) {
			$parts[] = $this->sqlLimit;
			$parts[] = SQLValue::getValue(1, DBValueType::Integer, $generator);
		}

		return (implode(" ", $parts));
	}

	public function getCondition($generator)
	{
		if ($this->expr) {
			return (SQL::compileWhereExpr($this->expr, $generator));
		}
		$pk = $this->primaryKeys();
		$exprArray = array();
		$defs = $this->object->getColumnDefinition();
		foreach ($pk as $name) {
			$def = $defs[$name];
			if ($this->signEnablePK && $this->object->isChanged() && $this->object->isMemberChanged($name)) {
				$exprArray[] = new ExprEQ($def, instance_cast($this->object, DBObject::class)->getPreviousValue($name));
			} else {
				$exprArray[] = new ExprEQ($def, $this->object->getValue($name));
			}
		}
		if (count($exprArray) > 1) {
			/** @var IExpression $expr */
			$expr = new ExprAND($exprArray);
		} else {
			/** @var IExpression $expr */
			$expr = array_shift($exprArray);
		}
		return (SQL::compileWhereExpr($expr, $generator));
	}

	public function _isMemberChanged(string $name): bool
	{
		if ($this->signForceUpdate) return true;
		return parent::_isMemberChanged($name);
	}

	public function addExpression(IExpression $expr): SQLStatement
	{
		if  ($this->expr) {
			$this->expr = new ExprAND([$this->expr, $expr]);
		}
		else
		{
			$this->expr= $expr;
		}
		return $this;
	}
}

