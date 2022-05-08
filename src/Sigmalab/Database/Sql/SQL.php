<?php

namespace Sigmalab\Database\Sql;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Expressions\ExprIN;
use Sigmalab\Database\Expressions\ExprNEQ;
use Sigmalab\Database\Expressions\ExprOR;
use Sigmalab\Database\Expressions\IExpression;


class SQL
{
	/**
	 * @param string $column
	 * @param mixed $value
	 * @param string $type
	 * @param SQLDic|null $sql
	 * @return string
	 */
	public function setValue(string $column, $value, string $type, ?SQLDic $sql = null)
	{
		if ($sql == null) {
			$sql = new SQLDic();
		}

		$text = SQLValue::getValue($value, $type, $sql);
		return ($sql->sqlOpenName . $column . $sql->sqlCloseName . " = $text");
	}

	public function compile(IExpression $expr, SQLGenerator $generator)
	{
		switch (get_class($expr)) {
			case ExprEQ::class:
			case ExprNEQ::class:
			case ExprIN::class:
			case ExprAND::class:
			case ExprOR::class:
				return (ECompilerSQL::s_compile($expr, $generator));
			default:
				return ("");
		}
	}

	/**
	 * compile Expression
	 *
	 * @param IExpression $expr expression
	 * @param SQLGenerator $generator SQL generator.
	 * @return string compiled query
	 */
	static function compileExpr(IExpression $expr, $generator)
	{
		return (ECompilerSQL::s_compile($expr, $generator));
	}

	static function compileWhereExpr(IExpression $expr, SQLGenerator $generator)
	{
		$compiler = new ECompilerSQL($generator);
		$compiler->generationMode = DBGenCause::Where;
		return $compiler->compile($expr);
	}

	/**
	 *  Quote variable to make safe
	 *
	 * @param string $value
	 * @return string
	 */
	function quoteSmart($value)
	{
		// Stripslashes
		if (get_magic_quotes_gpc()) {
			if (is_array($value) || is_object($value)) {
				throw new DatabaseArgumentException('$value should be simpletype , but got ' . gettype($value));
			}
			$value = stripslashes($value);
		}
		// Quote if not integer
		if (!is_numeric($value)) {
//			$value = "'" . mysql_real_escape_string($value) . "'";
			$value = "'" . $value . "'";
		}
		return $value;
	}


	/**
	 * Create select statement
	 *
	 * @param IDataObject $proto
	 * @return SQLStatementSelect
	 */
	public static function select($proto)
	{
		return new SQLStatementSelect($proto);
	}

}

