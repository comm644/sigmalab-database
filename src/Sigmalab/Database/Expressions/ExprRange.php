<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDBColumnDefinition;

/** advanced expression
 */
class ExprRange extends ExprDummy
{
	/**
	 * ExprRange constructor.
	 * @param IDBColumnDefinition $name
	 * @param float|int $min
	 * @param float|int $max
	 */
	public function __construct(IDBColumnDefinition $name, $min, $max)
	{
		$this->name = $name;
		parent::__construct([
			new ExprAND([
				new ExprGTE($name, $min),
				new ExprLTE($name, $max)
			])
		]);
	}
}