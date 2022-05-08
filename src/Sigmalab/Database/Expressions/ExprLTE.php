<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

class ExprLTE extends ExprBool
{
	/**
	 * ExprLTE constructor.
	 * @param IDBColumnDefinition $name
	 * @param string|int|float $value
	 */
	public function __construct(IDBColumnDefinition $name, $value)
	{
		parent::__construct("<=", $name, [new SQLValue($value)]);
	}
}