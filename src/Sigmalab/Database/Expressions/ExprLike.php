<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Sql\IColumnName;
use Sigmalab\Database\Sql\SQLValue;

class ExprLike extends ExprBool
{
	public function __construct(IDBColumnDefinition $name, string $value)
	{
		parent::__construct("LIKE", $name, [new SQLValue($value)]);
	}

	public function compile(ECompilerSQL $compiler): string
	{
		$pos = 0;
		$query = ECompilerSQL::EMPTY;

		foreach ($this->args as $arg) {
			if ($pos > 0) $query .= " {$compiler->sqlDic->sqlAnd} ";
			$value = instance_cast($arg, SQLValue::class);
			$query .= $compiler->compileLike($compiler->getName($this->name), (string)$value->value);
			$pos++;
		}
		return ($compiler->sqlGroup($query));
	}
}