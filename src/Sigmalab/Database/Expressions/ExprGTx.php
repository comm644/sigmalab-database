<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\IDBColumnDefinition;

class ExprGTx extends ExprBool
{
	/**
	 * ExprGT constructor.
	 * @param IDBColumnDefinition $name
	 * @param IDBColumnDefinition $value
	 */
	public function __construct(IDBColumnDefinition $name, $value)
	{
		parent::__construct(">", $name, [$value]);
	}
}