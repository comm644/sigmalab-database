<?php

namespace Sigmalab\Database\Expressions;

/**
 * This class provides mathematics for expressions.
 */
class ExprMath extends SQLExpression
{
	public function __construct(string $opcode, IExpression $arg0, IExpression $arg1)
	{
		$args = [$arg0, $arg1];
		parent::__construct($opcode, $args);
	}
}