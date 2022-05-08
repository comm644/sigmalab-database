<?php

namespace Sigmalab\Database\Sql;

use Exception;
use Sigmalab\Database\Core\DBParam;
use Sigmalab\Database\Core\DBQuery;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\IsKPHP;
use Sigmalab\SimpleReflection\ClassRegistry;

class SQLStatementInsertBulk extends SQLStatementChange
{
	/** enable to validate "changed" state */
	public bool $signUseChangedMembers = false;

	/**
	 * If user wants to insert too many object by one SQL statement.
	 *
	 * @var IDataObject[]
	 */
	public array $objectArray = [];

	public function __construct(array $objs, $signEnablePK = false)
	{

		$dic = new SQLDic();
		$this->sqlStatement = $dic->sqlInsert;

		$this->objectArray = $objs;
		parent::__construct(\array_first_value($objs));
		$this->signEnablePK = $signEnablePK;
	}

	public function enableUseChangedMembers(bool $sign)
	{
		$this->signUseChangedMembers = $sign;
	}

	/**
	 * @return string[]
	 */
	protected function primaryKeys() :array
	{
		if ($this->signEnablePK) return (array());
		return (parent::primaryKeys());
	}

	/** protected. can be overried if need disable checking for "changed"
	 * @param string $name
	 * @return bool
	 */
	public function _isMemberChanged(string $name): bool
	{
		if (!$this->signUseChangedMembers) return true; //always changed
		return $this->object->isMemberChanged($name);
	}

	/** public. generate SQL query
	 * @param SQLGenerator $generator
	 * @param int $mode
	 * @return string
	 * @throws \Sigmalab\Database\DatabaseArgumentException
	 */
	public function generate(SQLGenerator $generator, int $mode = 0): string
	{
		$sql = $generator->getDictionary();
		$tname = new SQLName($this->table, null);

		$parts = array();
		$parts[] = $this->sqlStatement;
		$parts[] = $tname->generate($generator);


		$names = $this->_getColumnsArray($generator);

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(',', $names);
		$parts[] = $sql->sqlCloseFuncParams;
		$parts[] = $sql->sqlValues;

		//FIXME: here used hack because base class  knows nothing about multiple objects for inserting.
		$values = array();
		if ($this->objectArray) {
			foreach ($this->objectArray as $obj) {
				$this->object = $obj;
				$values[] = $this->generateValues($sql, $generator);
			}
		} else {
			$values[] = $this->generateValues($sql, $generator);
		}
		$parts[] = implode(",", $values);


		return (implode(" ", $parts));
	}

	public function generateValues(SQLDic $sql, SQLGenerator $generator)
	{
		$values = $this->_getValuesArray($generator);

		$parts = array();
		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(",\n", $values);
		$parts[] = $sql->sqlCloseFuncParams;
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
		if (!$generator) {
			throw new Exception("Invalid argument. 'generator' is null'");
		}
		$params = array();
		$names = array();
		$pholders = array();
		$rows = array();


		/** @var IDataObject $obj */
		foreach ($this->objectArray as $idx => $obj) {
			$pk = [(string)$obj->getPrimaryKeyTag()->getName()];;
			$defs = $obj->getColumnDefinition();

			foreach ($defs as $def) {
				$column = $def->getName();
				if (in_array($column, $pk) && ($this->signEnablePK == false)) continue;
				//if ( !$this->_isMemberChanged( $def->name ) ) continue;
				$pholderName = $generator->generatePlaceHolderName((string)$column) . '_' . $idx;
				if ( IsKPHP::$isUseReflection) {
					$value = $this->object->getValue((string)$column);
				}
				else {
#ifndef KPHP
					$value = $this->object->{$column};
#endif
				}

				$sqlName = new SQLName(null, $column);
				if ($idx == 0) {
					$names[] = $sqlName->generate($generator);
				}

				$pholders[] = $pholderName;

				$type = $def->getType();
				$param = new DBParam(
					$pholderName,
					SQLValue::getDbParamType($value, $type),
					SQLValue::getDbParamValue($value, $type, $generator)
				);

				$params[] = $param;
			}
			$rows[] = $pholders;
			$pholders = array();
		}

		$sql = $this->_generateParametrizedQuery($names, $rows, $generator);

		return new DBQuery($sql, $params);
	}


	/**
	 * Generate parametrizedquery for specifies names and placeholders.
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
		$parts[] = $sql->sqlInsert;
		$parts[] = $tname->generate($generator);

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = implode(',', $names);
		$parts[] = $sql->sqlCloseFuncParams;

		$parts[] = $sql->sqlValues;


		if ($this->objectArray) {
			foreach ($pholders as $idx => $row) {
				if ($idx > 0) {
					$parts[] = ",";
				}
				$parts[] = $sql->sqlOpenFuncParams;
				$parts[] = implode(',', $row);
				$parts[] = $sql->sqlCloseFuncParams;
			}
		} else {
			$parts[] = $sql->sqlOpenFuncParams;
			$parts[] = implode(',', $pholders);
			$parts[] = $sql->sqlCloseFuncParams;
		}


		return (implode(' ', $parts));
	}

	public function addExpression(IExpression $expr): SQLStatement
	{
		//nothing to do.
		return $this;
	}
}
