<?php
declare(strict_types=1);

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Sql\SQLValue;

class ExprEQ extends ExprBool
{
	private const IS = "IS";
	private const EQ = "=";

	/**
	 * ExprEQ constructor.
	 * @param IDBColumnDefinition $name
	 * @param int|string|null|bool|float $arg
	 * @kphp-template $arg
	 */
	public function __construct(IDBColumnDefinition $name, $arg)
	{
		if  (is_array($arg)){
			throw new DatabaseArgumentException("Invalid argument type. Array not supported yet.");
		}
		if (is_null($arg)) {
			parent::__construct(self::IS, $name, [new SQLValue(null)]);
			return;
		}
//		if (is_array($arg)) {
//			if (is_null($arg[0])) {
//				parent::__construct(self::IS, $name, [new SQLValue(null)]);
//				return;
//			}
//			parent::__construct("=", $name, array_map(function($arg){ return new SQLValue($arg);}, $arg));
//		}
		else {
			parent::__construct("=", $name, [new SQLValue($arg, $name->getType())]);
		}
	}

	/**
	 * ExprEQ constructor.
	 * @param IDBColumnDefinition $name
	 * @param IExpression $arg
	 */
	public static function eqColumn(IDBColumnDefinition $name, IExpression $arg):self
	{
		/** @var self $expr */
		$expr = new self($name, 0);
		$expr->args = [$arg];
		return $expr;
	}
	/**
	 * ExprEQ constructor.
	 * @param IDBColumnDefinition $name
	 * @param int|string|null|bool|float $arg
	 * @kphp-template T
	 * @kphp-param T $arg
	 */
	public static function eqValue(IDBColumnDefinition $name, $arg):self
	{
		$expr = new ExprEQ($name, 0);
		$expr->args = [new SQLValue($arg, $name->getType())];
		return $expr;
	}

	public static function isNull(IDBColumnDefinition $name):self
	{
		/** @var self $expr */
		$expr = new ExprEQ($name, 0);
		$expr->mode = self::IS;
		$expr->args = [new SQLValue(null)];
		return $expr;
	}

	public static function eqInt(IDBColumnDefinition $name, int $arg):self
	{
		/** @var self $expr */
		$expr = new ExprEQ($name, 0);
		$expr->mode = self::EQ;
		$expr->args = [new SQLValue($arg, DBValueType::Integer)];
		$expr->type = DBValueType::Integer;
		return $expr;
	}

	public static function eqString(IDBColumnDefinition $name, string $arg):self
	{
		/** @var self $expr */
		$expr = new self($name, ECompilerSQL::EMPTY);
		$expr->mode = self::EQ;
		$expr->args = [new SQLValue($arg, DBValueType::String)];
		$expr->type = DBValueType::String;
		return $expr;
	}
	public static function eqDatetime(IDBColumnDefinition $name, int $arg):self
	{
		$expr = new ExprEQ($name, ECompilerSQL::EMPTY);
		$expr->mode = self::EQ;
		$expr->args = [new SQLValue($arg, DBValueType::Datetime)];
		$expr->type = DBValueType::Datetime;
		return $expr;
	}
}
