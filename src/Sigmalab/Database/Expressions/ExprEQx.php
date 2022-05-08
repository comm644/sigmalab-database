<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\IDBColumnDefinition;

class ExprEQx extends ExprBool
{
	private const IS = "IS";
	private const EQ = "=";

	/**
	 * ExprEQ constructor.
	 * @param IDBColumnDefinition $name
	 * @param IExpression $arg
	 * @kphp-template $arg
	 */
	public function __construct(IDBColumnDefinition $name, IExpression $arg)
	{
		if (is_null($arg)) {
			parent::__construct(self::IS, $name, [$arg]);
			return;
		}
		parent::__construct("=", $name, [$arg]);
	}
}