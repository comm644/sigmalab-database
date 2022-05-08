<?php
namespace Sigmalab\Database\Expressions;


use Sigmalab\Database\Discovery\SqlPrint;

class ExprNOT implements IExpression, ICanCompileExpression
{
	public IExpression $expr;
	/**
	 * @var string
	 */
	public string $name = '';

	public string $type = ECompilerSQL::EMPTY;      //type of values (need for type conversion)

	public function __construct(IExpression $expr)
	{
		$this->name = " NOT ";
		$this->expr = $expr;
	}

	/**
	 * @param ECompilerSQL $compiler
	 * @return string
	 * @throws \Exception
	 */
	public function compile(ECompilerSQL $compiler): string
	{
		$query = ECompilerSQL::EMPTY;
		$query .= " {$this->name} ";
		$query .= $compiler->sqlGroup($compiler->compile($this->expr, $this->type));
		return $query;
	}

	public function __toString(): string
	{
		return SqlPrint::call("Expr{$this->name}  type=$this->type argsCount=",[$this->expr]);
	}
}
