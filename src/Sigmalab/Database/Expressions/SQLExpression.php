<?php

namespace Sigmalab\Database\Expressions;


use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Discovery\SqlPrint;

/** multiargument expression
 */
class SQLExpression implements IExpression, ICanCompileExpression
{
	public string $mode = ECompilerSQL::EMPTY; //join mode
	/**
	 * @var IExpression[]
	 */
	public array $args;      //array of arguments
	public string $type = DBValueType::Integer;      //type of values (need for type conversion)

	/**
	 * SQLExpression constructor.
	 * @param string $mode
	 * @param IExpression[] $args
	 */
	public function __construct(string $mode, array $args)
	{
		$this->mode = $mode;
		$this->args = $args;
	}

	public function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args) == 0) return (ECompilerSQL::EMPTY);
		$query = ECompilerSQL::EMPTY;
		$pos = 0;
		foreach ($this->args as $arg) {
			if ($pos > 0) $query .= " {$this->mode} ";
//			if (is_scalar($arg) || is_null($arg)) {
//				$query .= $compiler->compile(new SQLValue($arg, $this->type), $this->type);
//			} else
			{
				$query .= $compiler->compile($arg, $this->type);
			}
			$pos++;
		}
		return ($compiler->sqlGroup($query));
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
		return SqlPrint::call("Expr{$this->mode}  type=$this->type argsCount=" . count($this->args), $this->args);
	}
}