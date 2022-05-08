<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBCommandContainer;
use Sigmalab\Database\Core\DBParam;
use Sigmalab\Database\Core\DBQuery;
use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\DatabaseException;
use Sigmalab\IsKPHP;
use Sigmalab\SimpleReflection\ClassRegistry;

/**
 * Base class for all chaching operations. Do not use directly
 *
 */
abstract class SQLStatementChange extends SQLStatement
{
	/**  enable using user defined Primary key in insert/update operations
	 * @var bool
	 */
	public bool $signEnablePK = false;

	/**
	 * SQLStatementChange constructor.
	 * @param IDataObject $obj
	 */
	public function __construct(IDataObject $obj)
	{
		parent::__construct($obj);
	}

	/** private. return SQL values array  for changing
	 * @param SQLGenerator $generator
	 * @return string
	 */
	public function _getValues(SQLGenerator $generator)
	{
		return (implode(",", $this->_getValuesArray($generator)));
	}

	/** private. return SQL names for changing
	 * @param SQLGenerator $generator
	 * @return string
	 */
	public function _getColumns(SQLGenerator $generator)
	{
		return (implode(",", $this->_getColumnsArray($generator)));
	}

	/** private. return SQL value pairs for changing
	 * @param SQLGenerator $generator
	 * @return string
	 */
	public function _getValuePairs(SQLGenerator $generator)
	{
		return (implode(",", $this->_getValuePairsArray($generator)));
	}

	/** private. return values array for changing
	 * @param SQLGenerator $generator
	 * @return array
	 */
	public function _getValuesArray(SQLGenerator $generator)
	{
		$pk = $this->primaryKeys();
		$defs = $this->columnDefs;
		$values = array();
		foreach ($defs as $def) {
			$columnName = (string)$def->getName();
			if (in_array($columnName, $pk) and !$this->signEnablePK) continue;
			if (!$this->_isMemberChanged($columnName)) continue;

			if (IsKPHP::$isKPHP) {
				$value = $this->object->getValue((string)$columnName);
			} else {
#ifndef KPHP
				$value = $this->object->{$def->name};
#endif
			}

			$values[] = SQLValue::getValue($value, $def->getType(), $generator);
		}
		return ($values);
	}

	/** private. return values array for changing
	 * @param SQLGenerator $generator
	 * @return string[]
	 * @throws \Sigmalab\Database\DatabaseArgumentException
	 */
	public function _getValuePairsArray(SQLGenerator $generator):array
	{
		$sql = $generator->getDictionary();

		$values = $this->_getValuesArray($generator);
		$names = $this->_getColumnsArray($generator);

		$count = count($values);

		/** @var string[] $pairs */
		$pairs = array();
		for ($i = 0; $i < $count; ++$i) {
			$pairs[] = $names[$i] . $sql->sqlAssignValue . $values[$i];
		}
		return ($pairs);
	}

	/** private. return columns array for changing
	 * @param SQLGenerator $generator
	 * @return string[]
	 * @throws \Sigmalab\Database\DatabaseArgumentException
	 */
	public function _getColumnsArray(SQLGenerator $generator) :array
	{
		$pk = $this->primaryKeys();
		$defs = $this->columnDefs;
		$items = array();
		foreach ($defs as $def) {
			$columnName = (string)$def->getName();
			if (in_array($columnName, $pk) && !$this->signEnablePK) continue;
			if (!$this->_isMemberChanged($columnName)) continue;

			$sqlName = new SQLName(null, $columnName);

			$items[] = $sqlName->generate($generator);
		}
		return ($items);
	}

	/** public. genrarate SQL query
	 * @param SQLGenerator $generator
	 * @param int $mode
	 * @return string
	 */
	public function generate(SQLGenerator $generator, int $mode = 0): string
	{
		$sql = $generator->getDictionary();
		$tname = new SQLName($this->table, null);

		$parts = array();
		$parts[] = $this->sqlStatement;
		$parts[] = $tname->generate($generator);
		$parts[] = $sql->sqlSet;
		$parts[] = $this->_getValuePairs($generator);

		return (implode(" ", $parts));
	}

	/**
	 * Generate parametrized query.
	 *
	 * @param SQLGenerator $generator
	 * @return DBQuery
	 */
	public function generateQuery(SQLGenerator $generator): DBQuery
	{
		$params = array();
		$names = array();
		$pholders = array();

		$pk = $this->primaryKeys();
		$defs = $this->columnDefs;

		foreach ($defs as $def) {
			$columnName = $def->getName();
			$columnType = $def->getType();
			if (in_array($columnName, $pk) && ($this->signEnablePK == false)) continue;
			if (!$this->_isMemberChanged((string)$columnName)) continue;

			$pholderName = $generator->generatePlaceHolderName((string)$columnName);
			if (IsKPHP::$isUseReflection) {
				$value = $this->object->getValue((string)$columnName);
			} else {
#ifndef KPHP
				$value = $this->object->{$def->name};
#endif
			}

			$sqlName = new SQLName(null, $columnName, $columnType);
			$names[] = $sqlName->generate($generator);

			$pholders[] = $pholderName;

			$param = new DBParam(
				$pholderName,
				SQLValue::getDbParamType($value, $columnType),
				SQLValue::getDbParamValue($value, $columnType, $generator)
			);

			$params[] = $param;
		}
		$sql = $this->_generateParametrizedQuery($names, $pholders, $generator);

		return new DBQuery($sql, $params);
	}

	/**
	 * Generate parametrized query for specifies names and placeholders.
	 * this mehod can be overriden in inherit class for customize query generation.
	 *
	 * @param array $names sql names string array.
	 * @param array $pholders sql placeholders string array
	 * @param SQLGenerator $generator SQL generator.
	 * @return string
	 * @access protected
	 */
	public function _generateParametrizedQuery(array $names, array $pholders, SQLGenerator $generator): string
	{
		$sql = $generator->getDictionary();
		$tname = new SQLName($this->table, null);

		$parts = array();
		$parts[] = $this->sqlStatement;
		$parts[] = $tname->generate($generator);
		$parts[] = $sql->sqlSet;

		$count = count($names);
		$pairs = array();
		for ($pos = 0; $pos < $count; ++$pos) {
			$pairs[] = $names[$pos] . $sql->sqlAssignValue . $pholders[$pos];
		}
		$parts[] = implode(',', $pairs);

		return (implode(' ', $parts));
	}


	/** protected. can be overried if need disable checking for "changed"
	 * @param string $name
	 * @return bool
	 */
	public function _isMemberChanged(string $name): bool
	{
		return $this->object->isMemberChanged($name);
	}

	/**
	 * create default result container
	 *
	 * @return DBResultContainer
	 */
	public function createResultContainer(): DBResultContainer
	{
		return new DBCommandContainer();
	}

	/**
	 *  Enable to change primary key.
	 * @param bool $sign true is PK changing enabled.
	 */
	public function enableChangePK($sign = true)
	{
		$this->signEnablePK = $sign;
	}

}


