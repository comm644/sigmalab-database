<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Discovery\SqlPrint;

class ExprLogic implements IExpression, ICanCompileExpression
{
	/**
	 * @var string
	 */
	public string $mode = ECompilerSQL::EMPTY; //join mode
	/**
	 * @var IExpression[]
	 */
	public array $args;      //array of arguments

	/**
	 * SQLExpression constructor.
	 * @param string $mode
	 * @param IExpression[] $args
	 */
	public function __construct(string $mode, array $args)
	{
		$this->mode = $mode;
		$this->args = $args;
		foreach ($args as $arg) {
			if (is_null($arg)) throw new DatabaseArgumentException("Argument can't be NULL");
		}
	}

	public function compile(ECompilerSQL $compiler): string
	{
		if (!count($this->args)) return ECompilerSQL::EMPTY;
		$parts = [];
		foreach ($this->args as $arg) {
			$parts[] = $compiler->compile($arg);
		}
		return $compiler->sqlGroup(implode(" " . $this->mode . " ", $parts));
	}


	public function __toString(): string
	{
		return $this->toString();
	}


	/**
	 * @return string
	 */
	protected function toString(): string
	{
		return SqlPrint::call("Logic{$this->mode} argsCount=" . count($this->args), $this->args);
	}

}