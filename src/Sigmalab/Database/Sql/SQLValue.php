<?php

/* * ****************************************************************************
  Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.
  -----------------------------------------------------------------------------
  Module     : SQL Value converter
  File       : SQLValue.php
  Author     : Alexei V. Vasilyev
  -----------------------------------------------------------------------------
  Description:

  require: DataSource global defined class
 * **************************************************************************** */

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Expressions\ECompilerSQL;


class SQLValue implements ICanGenerateOne

{

	/**
	 * value
	 *
	 * @var mixed
	 */
	public $value;

	/**
	 * internal SQL type for values
	 *
	 * @var string
	 */
	public string $type = '';

	/**
	 * construct SQL value container
	 *
	 * @param string|int|null|float $value
	 * @param string|null $type
	 */
	public function __construct($value, ?string $type = null)
	{
		$this->value = $value;

		if (is_null($type)) {
			$this->type = gettype($value);
		} else {
			$this->type = (string)$type;
		}
	}
	/**
	 * @inheritDoc
	 */
	public function generate(SQLGenerator $generator, int $cause = 0): string
	{
		$value = $this->value;
		return self::getValue($value, $this->type, $generator);
	}

	public function compileExpression(ECompilerSQL $compiler):string
	{
		$value = $this->value;
//#ifndef KPHP
//		if ($value instanceof ICanCompileExpression) {
//			$compiler->pushMode(DBGenCause::Where);
//			$result = $value->compile($compiler);
//			$compiler->popMode();
//			return $result;
//		}
//#endif
		return self::getValue($value, $this->type, $compiler->generator);
	}

	/**
	 *  Present value as string for using in SQL query.
	 *
	 * @param string $value
	 * @param SQLGenerator $generator
	 * @return string
	 */
	public static function getAsString(string $value, SQLGenerator $generator)
	{
		return implode("", array(
			$generator->getDictionary()->sqlStringOpen,
			$generator->escapeString($value),
			$generator->getDictionary()->sqlStringClose));
	}

	public static function getAsBLOB(&$value, SQLGenerator $generator)
	{
		return $generator->generateValueAsBLOB($value);
	}

	/**
	 * @param mixed|null $value
	 * @return string
	 */
	public static function getAsInt( $value):string
	{
		//process foreign-keys
		if ($value === "")
			return (SQLValue::getAsNull());
		if (is_null($value))
			return (SQLValue::getAsNull());
		return (sprintf("%d", $value));
	}

	/**
	 * @param mixed|null $value
	 * @return string
	 */
	private static function getAsFloat($value):string
	{
		if ($value === "")
			return (SQLValue::getAsNull());
		if (is_null($value))
			return (SQLValue::getAsNull());

		return number_format($value,10, '.', '');
	}


	/**
	 * @param mixed $value
	 * @param \Sigmalab\Database\Sql\SQLGenerator $generator
	 * @return string
	 */
	public static function getAsDatetime($value, SQLGenerator $generator): string
	{
		if (is_string($value))
			return (sprintf("'%s'", $value));
		return (sprintf("'%s'", $generator->generateDateTime((int)$value)));
	}

	/**
	 * @param mixed $value
	 * @param \Sigmalab\Database\Sql\SQLGenerator $generator
	 * @return string
	 */
	public static function getAsDate($value, SQLGenerator $generator)
	{
		if (is_string($value))
			return (sprintf("'%s'", $value));
		return (sprintf("'%s'", $generator->generateDate((int)$value)));
	}

	/**
	 * @param mixed $value
	 * @return int|null
	 * @throws DatabaseArgumentException
	 */
	public static function fromSqlDateTime($value):?int
	{
		if (is_null($value)) {
			return null;
		}
		$parts = preg_split("/[ T\.\-:]/", $value);
		if (count($parts) < 6) {
			if  (is_int($value)) {
				return (int)$value;
			}
			throw new DatabaseArgumentException("not expected SQL datetime: $value");
		}
		list($year, $month, $day, $hour, $min, $sec) = $parts;
		$result = mktime(
			intval($hour), intval($min), intval($sec), intval($month), intval($day), intval($year));
		return $result;
	}

	public static function fromSqlDate($value)
	{
		if (!$value) {
			return null;
		}
		$parts = preg_split("/[ T\.\-]/", $value);
		if (count($parts) < 3) {
			new DatabaseArgumentException("not expected SQL date: $value");
		}
		list($year, $month, $day) = $parts;
		$result = mktime(
			null, null, null, intval($month), intval($day), intval($year));
		return $result;
	}

	/**
	 * @return string
	 */
	public static function getAsNull()
	{
		return ("NULL");
	}

	/** returns SQL value with conversion according to Type Definition
	 * @param mixed $value
	 * @param string $type
	 * @param SQLGenerator $generator
	 * @return string
	 */
	public static function getValue($value, string $type, SQLGenerator $generator)
	{
		if (is_null($value))
			return ("NULL");

		if (!$type)
			$type = gettype($value);

		switch ($type) {
			default:
			case "enum":
			case "text":
			case "string":
				return (SQLValue::getAsString((string)$value, $generator));
				break;

			case "longblob":
			case "tinyblob":
			case "mediumblob":
			case "blob":
				return (SQLValue::getAsBLOB($value, $generator));
				break;
			case "int":
			case "integer":
				return (SQLValue::getAsInt($value));
				break;
			case "double":
			case "float":
				return (SQLValue::getAsFloat((float)$value));
				break;
			case "date":
				return (SQLValue::getAsDate($value, $generator));
				break;
			case "datetime":
				return (SQLValue::getAsDatetime($value, $generator));
				break;
		}
	}

	/** returns DBParamType  for specified  Type Definition
	 *
	 * @param mixed $value value for parameter, required for NULL detection.
	 * @param string|null $type DbType  defined in DBObject/DBColumnDefinition
	 * @return int
	 */
	public static function getDbParamType($value, ?string $type = null): int
	{
		if (is_null($value)) {
			return (DBParamType::Null);
		}

		if (is_null($type)) {
			$type = gettype($value);
		}

		switch ($type) {
			default:
			case "enum":
			case "date":
			case "datetime":
			case "string":
				return (DBParamType::String);

			case "bool":
			case "boolean":
				return DBParamType::Bool;

			case "tinyint":
			case "smallint":
			case "biglint":
			case "mediumint":
			case "int":
			case "integer":
				return (DBParamType::Integer);

			case "double":
			case "float":
				return DBParamType::Real;


			case "longblob":
			case "tinyblob":
			case "mediumblob":
			case "blob":
				return (DBParamType::Lob);
		}
	}

	/** get value according to type and database engine.
	 * @param $value
	 * @param string|null $type
	 * @param SQLGenerator $generator
	 * @return mixed
	 */
	public static function getDbParamValue($value, ?string $type, SQLGenerator $generator)
	{
		if (is_null($value))
			return (null);
		if (is_null($type))
			$type = gettype($value);

		switch ($type) {
			case "datetime":
				if (is_string($value)) return ($value);
				return ($generator->generateDateTime((int)$value));

			case "date":
				if (is_string($value)) return ($value);
				return ($generator->generateDate((int)$value));

			default:
				return $value;
		}
	}

	public static function importValue($value, IDBColumnDefinition $def)
	{
		if ($def->isNullable() && is_null($value)) {
			return null;
		}
		$type = $def->getType();

		switch ($type) {
			case "datetime":
				if (is_null($value)) return null;
				return (SQLValue::fromSqlDateTime($value));

			case "date":
				if (is_null($value)) return null;
				return (SQLValue::fromSqlDate($value));

			case "tinyint":
			case "smallint":
			case "bigint":
			case "mediumint":
			case "int":
			case "integer":
				return (intval($value));
				break;

			case "double":
			case "float":
			case "real":
				return floatval($value);

			case "string":
			case "varchar":
			case "text":
				if (is_null($value)) return "";
				return $value;

			default:
				return $value;
		}
	}

	public function __toString(): string
	{
		return $this->toString();
	}

	/**
	 * @return string
	 */
	protected function toString(): string
	{
		return "(SQLValue type=$this->type" .
			"\n   ($this->value))";
	}

	public static function intValue(int $value):self
	{
		return new SQLValue($value, DBValueType::Integer);
	}
	public static function floatValue(int $value):self
	{
		return new SQLValue($value, DBValueType::Float);
	}
}
