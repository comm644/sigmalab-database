<?php


namespace Sigmalab\Database\Discovery;


use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\Database\Sql\SQLStatement;

class SqlPrint
{
	public const INDENT = " ";
	public const LINE = "\n".self::INDENT;
	public static function indent(string $s):string
	{
		return str_replace("\n", self::LINE,$s);
	}
	public static function args(array $args):string
	{
		return implode(self::LINE, array_map(fn($x)=>(string)$x, $args));
	}

	/**
	 * @param string $method
	 * @param IExpression[] $args
	 * @kphp-template T
	 * @kphp-param  T $args
	 * @return string
	 */
	public static function call(string $method, array $args)
	{
		return "($method\n"
			. self::INDENT . self::INDENT . self::indent(SqlPrint::args(array_map(function ($arg) {
				if  (is_null($arg)) return "NULL";
				return (string)$arg;
			}, $args)))
			.")";
	}

	public static function dump(SQLStatement $stm):string
	{
		return $stm->__toString()."\n\n";
	}
}