<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

class ExprNEQ extends ExprBool
{
	/**
	 * ExprBool constructor.
	 * @param IDBColumnDefinition $name
	 * @param int|string|float|null $value
	 */
	public function __construct(IDBColumnDefinition $name, $value)
	{
//		if (is_array($values)) {
//			if ((count($values) == 1) && is_null( array_first_value($values))) {
//				parent::__construct("IS NOT", $name, array_first_value($values));
//			} else {
//				parent::__construct("!=", $name, $values);
//			}
//		} else
		if (is_null($value)) {
			parent::__construct("IS NOT", $name, [new SQLValue(null)]);
		} else {
			parent::__construct("!=", $name, [new SQLValue($value)]);
		}
	}
}