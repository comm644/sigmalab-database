<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

class ExprLT extends ExprBool
{
	/**
	 * ExprLT constructor.
	 * @param IDBColumnDefinition $name
	 * @param int|string|float $value
	 */
	public function __construct(IDBColumnDefinition $name, $value)
	{
		parent::__construct("<", $name, [new SQLValue($value)]);
	}
}