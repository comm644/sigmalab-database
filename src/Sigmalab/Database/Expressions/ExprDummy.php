<?php

namespace Sigmalab\Database\Expressions;

class ExprDummy implements IExpression, ICanCompileExpression
{
	/**
	 * @var IExpression[]
	 */
	public array $args;

	/**
	 * ExprDummy constructor.
	 * @param IExpression[] $args
	 */
	public function __construct(array $args)
	{
		$this->args = $args;
	}

	public function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args) == 0) return (ECompilerSQL::EMPTY);
		$query = ECompilerSQL::EMPTY;
		foreach ($this->args as $arg) {
			$query .= $compiler->compile($arg);
		}
		return ($query);
	}

	public function __toString(): string
	{
		return __CLASS__;
	}
}