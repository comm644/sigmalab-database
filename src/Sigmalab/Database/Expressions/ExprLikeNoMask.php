<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

class ExprLikeNoMask extends ExprLike
{
	public function __construct(IDBColumnDefinition $name, string $value)
	{
		parent::__construct($name, $value);
	}

	public function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args) == 0) return ECompilerSQL::EMPTY;
		$query = ECompilerSQL::EMPTY;
		$pos = 0;
		foreach ($this->args as $arg) {
			if ($pos > 0) $query .= " {$compiler->sqlDic->sqlAnd} ";
			$query .= $compiler->compile($this->name, $this->type);
			$query .= " {$this->mode} ";
			/** @noinspection PhpParamsInspection */
			$query .= $compiler->compileValue(instance_cast($arg, SQLValue::class));
			$pos++;
		}
		return ($compiler->sqlGroup($query));
	}
}