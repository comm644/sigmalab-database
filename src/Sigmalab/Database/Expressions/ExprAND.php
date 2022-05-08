<?php

namespace Sigmalab\Database\Expressions;

class ExprAND extends ExprLogic
{
	/**
	 * ExprAND constructor.
	 * @param IExpression[] $args
	 * @throws \Sigmalab\Database\DatabaseArgumentException
	 */
	public function __construct(array $args)
	{
		parent::__construct("AND", $args);
	}
}