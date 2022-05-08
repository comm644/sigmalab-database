<?php
declare(strict_types=1);

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Sql\SQLValue;

class ExprGTE extends ExprBool
{
	private const GTE = ">=";

	/**
	 * ExprGTE constructor.
	 * @param IDBColumnDefinition $name
	 * @param int|float $value
	 */
	public function __construct(IDBColumnDefinition $name, $value)
	{
		parent::__construct(self::GTE, $name, [new SQLValue($value)]);
	}

	public static function gteInt(IDBColumnDefinition $name, int $arg):self
	{
		$expr = new ExprGTE($name, 0);
		$expr->mode = self::GTE;
		$expr->args = [new SQLValue($arg, DBValueType::Integer)];
		return $expr;
	}
}