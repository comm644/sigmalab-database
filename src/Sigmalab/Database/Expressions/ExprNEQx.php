<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\IDBColumnDefinition;

class ExprNEQx extends ExprBool
{
	/**
	 * ExprBool constructor.
	 * @param IDBColumnDefinition $name
	 * @param IDBColumnDefinition $value
	 */
	public function __construct(IDBColumnDefinition $name, IDBColumnDefinition $value)
	{
		parent::__construct("!=", $name, [$value]);
	}
}