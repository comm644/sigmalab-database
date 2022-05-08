<?php

namespace Sigmalab\Database\Expressions;

class ExprOR extends ExprLogic
{
	/**
	 * ExprOR constructor.
	 * @param IExpression[] $args
	 * @throws \Sigmalab\Database\DatabaseArgumentException
	 */
	public function __construct(array $args)
	{
		parent::__construct("OR", $args);
	}
}