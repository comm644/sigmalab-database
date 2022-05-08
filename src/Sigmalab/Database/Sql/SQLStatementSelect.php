<?php
/******************************************************************************
 * Copyright (c) 2007 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : SELECT statement
 * File       : SQLStatementSelect.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 ******************************************************************************/

namespace Sigmalab\Database\Sql;

use ADO\src\Sigmalab\Database\Core\DBSettings;
use Sigmalab\Database\Core\DBArrayResult;
use Sigmalab\Database\Core\DBForeignKey;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBQuery;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\DatabaseException;
use Sigmalab\Database\Discovery\SqlPrint;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\IExpression;
use Sigmalab\IsKPHP;
use Sigmalab\SimpleReflection\ClassRegistry;

class SQLStatementSelect extends SQLStatement
{
	/** @access private section */

	public string $sqlAs = "AS";
	public string  $sqlOrder = "ORDER BY";
	public string  $sqlFrom = "FROM";
	public string  $sqlGroup = "GROUP BY";

	public ?IExpression $expr = null;

	/** @var SQLOrder[] */
	public array $order = array();

	/** @var SQLGroup[] */
	public array  $group = array();

	/** @var SQLJoin[] */
	public array  $joins = array();

	/** @var SQLLimit */
	public ?SQLLimit $limit = null;

	/** @var SQLOffset */
	public ?SQLOffset $offset = null;

	public array $queryParams = [];
	public string $querySql = "";
	public ?IExpression $having = null;

	/** Array with all prototypes used for construct statement
	 * @var IDataObject[]
	 */
	public array $prototypes = array();

	/** \publicsection */


	/** construct statement
	 *
	 * @param $obj IDataObject database object prototype
	 */
	public function __construct(IDataObject $obj)
	{
		parent::__construct($obj);

		$this->sqlStatement = "SELECT";
		$this->sqlWhere = "WHERE";

		$this->joins = array();
		$this->cacheKey = get_class($obj) . "\n";
		$this->cacheIt();
	}

	/** reset column information */
	public function resetColumns(): self
	{
		$this->columnDefs = array();
		$this->cacheIt();
		return $this;
	}

	/** add column in query
	 * @param IDBColumnDefinition $def target column
	 * @return SQLStatementSelect
	 */
	public function addColumn(IDBColumnDefinition $def): self
	{
		$this->columnDefs[$def->getAliasOrName()] = $def;
		$this->cacheIt();
		return $this;
	}

	public function removeColumn(IDBColumnDefinition $def): self
	{
		unset($this->columnDefs[$def->getAliasOrName()]);
		$this->cacheIt();
		return $this;
	}

	/** Add join by SQLJon spec
	 * @param SQLJoin $join foreign key tag
	 * @return SQLStatementSelect
	 */
	public function addJoin(SQLJoin $join): self
	{
		$this->cacheIt();
		if ($this->isJoined($join)) {
			return $this;
		}
		$this->joins[] = $join;
		return $this;
	}

	/** add join condition specified by foreing key tag
	 * @param DBForeignKey $key
	 * @return SQLStatementSelect
	 */
	public function addJoinByKey(DBForeignKey $key): self
	{
		$this->cacheIt();
		$this->joins[] = SQLJoin::createByKey($key, $this->object);
		return $this;
	}

	/**
	 * add join expression
	 *
	 * @param SQLJoin $expr
	 * @return SQLStatementSelect
	 */
	public function addJoinExpr(SQLJoin $expr)
	{
		$this->cacheIt();
		$this->joins[] = $expr;
		return $this;
	}

	/**
	 * Add WHERE expression with AND clause or set expression
	 * if was empt not exists.
	 *
	 * @param $expr  IExpression object defined condition
	 * @return self actual whichy will by applied in SQL query.
	 */
	public function addExpression(IExpression $expr): self
	{
		$this->cacheIt();
		if ($this->expr !== null) {
			$this->setExpression(new ExprAND([$this->expr, $expr]));
		} else {
			$this->setExpression($expr);
		}
		return $this;
	}

	/**
	 *  Set WHERE expression directly.
	 *
	 * @param $expr  IExpression|null object defined condition
	 * @return self
	 */
	public function setExpression(?IExpression $expr): self
	{
		$this->cacheIt();
		$this->expr = $expr;
		return $this;
	}

	public function getExpression(): IExpression
	{
		return $this->expr;
	}


	/** add order condition
	 * @param ICanGenerateOne $column target column for order definition
	 * @param bool $ascending \a true ascending mode, else descending mode
	 * @return SQLStatementSelect
	 */
	public function addOrder(ICanGenerateOne $column, bool $ascending = true):self
	{
		$this->cacheIt();
		if (is_null($column)) return $this;

		$this->addSqlOrder(new SQLOrder($column, $ascending));
		return $this;
	}

	/**
	 * Add composed SQL statement as order.
	 *
	 * @param SQLOrder $stm
	 * @return SQLStatementSelect
	 */
	public function addSqlOrder(SQLOrder $stm):self
	{
		$this->cacheIt();
		$this->order[] = $stm;
		return $this;
	}

	/** add groupping condition
	 * @param IDBColumnDefinition $column target column for grouping feature
	 * @return self
	 */
	public function addGroup(IDBColumnDefinition $column): self
	{
		$this->cacheIt();
		if (is_null($column)) return $this;

		$this->group[] = new SQLGroup($column);
		return $this;
	}

	/** set LIMIT feature
	 * @param int $limit number of records for limit
	 * @return SQLStatementSelect
	 */
	public function setLimit(int $limit)
	{
		$this->cacheIt();
		$this->limit = new SQLLimit($limit);
		return $this;
	}

	/** set OFFSET feature
	 * @param int $offset start offset for query
	 * @return SQLStatementSelect
	 */
	public function setOffset(int $offset)
	{
		$this->cacheIt();
		$this->offset = new SQLOffset($offset);
		return $this;
	}

	/** @access private
	 * get  array of all primary keys
	 *
	 * @return string[] array of all primary keys
	 */
	protected function primaryKeys(): array
	{
		return [(string)$this->object->getPrimaryKeyTag()->getName()];
	}

	protected function conditionalGenerate(IExpression $expr, SQLGenerator $generator, int $mode = SelectGeneratorMode::Normal): string
	{
		switch ($mode) {
			case SelectGeneratorMode::Normal:
				return $this->generateCondition($expr, $generator);
			case SelectGeneratorMode::Parametrized:
				return $this->generateParametrizedCondition($expr, $generator);
		}
		return "";
	}

	/**
	 * @access protected
	 * get SQL query (only MySQL supported now )
	 * @param SQLGenerator $generator
	 * @param int $mode
	 * @return string generated SQL query
	 */
	public function generate($generator, int $mode = 0): string
	{
		$sql = $generator->getDictionary();

		$parts = array();
		$parts[] = $sql->sqlSelect;
		$parts[] = $this->getColumns($generator);
		$parts[] = $sql->sqlFrom;
		$parts[] = $this->_getTables($generator);

		if (count($this->joins) != 0) {
			$parts[] = $this->getJoins($generator);
		}

		if ($this->expr) {
			$parts[] = $sql->sqlWhere;
			$parts[] = $this->conditionalGenerate($this->expr, $generator, $mode);
		}
		if (count($this->group) != 0) {
			$parts[] = $sql->sqlGroup;
			$parts[] = $this->_getOrder($this->group, $generator);
		}
		if ($this->having) {
			$parts[] = $sql->sqlHaving;
			$parts[] = $this->conditionalGenerate($this->having, $generator, $mode);
		}

		if (count($this->order) != 0) {
			$parts[] = $sql->sqlOrder;
			$parts[] = $this->_getOrder($this->order, $generator);
		}
		if (!is_null($this->limit)) {
			$parts[] = $this->limit->generate($generator);
		}
		if (!is_null($this->offset)) {
			$parts[] = $this->offset->generate($generator);
		}
		return (implode("\n ", $parts));
	}

	private function generateCondition(IExpression $expr, SQLGenerator $generator)
	{
		return SQL::compileWhereExpr($expr, $generator);
	}

	/**
	 * Generate parametrized condition
	 *
	 * @param IExpression $expr
	 * @param SQLGenerator $generator
	 * @return string
	 * @throws \Exception
	 */
	public function generateParametrizedCondition(IExpression $expr, SQLGenerator $generator): string
	{
		$compiler = new ECompilerSQL($generator, true);
		$compiler->generationMode = DBGenCause::Where;
		$sql = $compiler->compile($expr);

		if ($this->expr) {
			$params = $compiler->getParameters();
		} else {
			$params = array();
		}
		$this->queryParams = $params;
		return $sql;
	}

	public function generateQuery(SQLGenerator $generator): DBQuery
	{
		if (!$this->cacheKey) {
			$this->queryParams = array();
			$sql = $this->generate($generator, SelectGeneratorMode::Parametrized);
			$this->querySql = $sql;
			return new DBQuery($sql, $this->queryParams);
		}
		//cacheKey present

		//The main problem is:
		// 1st call:  'column' IS NULL
		// 2nd call:  'column = :p0
		// solution: detect null value and don't store it.
		// solution: verify count of params


		global $__sqlStatementSelect;
		if (!isset($__sqlStatementSelect) || !$__sqlStatementSelect) {
			$__sqlStatementSelect = array();
		}
		if (isset($__sqlStatementSelect[$this->cacheKey])) {
			$this->queryParams = array();
			$this->generateParametrizedCondition($this->expr, $generator);
			$subkey = count($this->queryParams);
			$sql = $__sqlStatementSelect[$this->cacheKey . "-" . $subkey];
			$this->querySql = $sql;
			return new DBQuery($sql, $this->queryParams);
		}

		$this->queryParams = array();
		$sql = $this->generate($generator, SelectGeneratorMode::Parametrized);
		$this->querySql = $sql;

		$subkey = count($this->queryParams);
		$__sqlStatementSelect[$this->cacheKey . "-" . $subkey] = $sql;


		return new DBQuery($sql, $this->queryParams);
	}

	/**
	 * get joins conditions
	 * @access private
	 * @param SQLGenerator $generator
	 * @return string generated JOIN conditions
	 */
	private function getJoins(SQLGenerator $generator): string
	{
		$parts = array();
		/** @var SQLJoin $join */
		foreach ($this->joins as $join) {
			$parts[] = $join->generate($generator);
		}
		return (implode(" ", $parts));
	}


	/** @access private
	 * get columns for query
	 * @param SQLGenerator $generator
	 * @return string columns conditions
	 */
	private function getColumns(SQLGenerator $generator)
	{
		$parts = array();
		foreach ($this->columnDefs as $def) {
			$str = array();
			if ($def instanceof ICanGenerateOne) {
				$str[] = $def->generate($generator, DBGenCause::Columns);
			} else {
				$str[] = $def->generate($generator, DBGenCause::Columns);
			}

			$parts[] = implode(" ", $str);
		}
		return (implode(",\n ", $parts));
	}


	/** @access private
	 * get tables for query
	 * @param SQLGenerator $generator
	 * @return string generated tables query
	 */
	private function _getTables(SQLGenerator $generator): string
	{
		$parts = array();
		$alias = new SQLAlias(
			$this->object->table_name(), '',
			(string)$this->object->getTableAlias());

		$parts[] = $alias->generate($generator);
//		if ($this->alsoTables) {
//			foreach ($this->alsoTables as $table) {
//				$name = new SQLName((string)$table, null);
//				$parts[] = $name->generate($generator);
//			}
//		}
		$query = implode(",", $parts);
		if ((count($parts) > 1) && (count($this->joins) != 0)) { //MySql 5.0 requirements
			$query = "(" . $query . ")";
		}
		return ($query);
	}

	/** @access private
	 * get order  for query
	 * @param SQLGenerator $generator
	 * @param ICanGenerate[] $list target columns
	 * @return string
	 */
	private function _getOrder(array $list, SQLGenerator $generator): string
	{
		if (count($list) == 0) return "";
		$parts = array();
		foreach ($list as $column) {
			$parts[] = $column->generate($generator, $this->table);
		}
		return (implode(",", $parts));
	}

	/**
	 * create default result container
	 *
	 * @param bool $signUseID set true if need use primary keys as array indexes
	 * @return SQLStatementSelectResult
	 */
	public function createResultContainer($signUseID = true): SQLStatementSelectResult
	{
		return new SQLStatementSelectResult($this, $signUseID);
	}

	/**
	 * @param mixed $sqlObject
	 * @return IDataObject
	 */
	public function readSqlObject(array $sqlObject): IDataObject
	{
		$newobj = $this->object->createSelf();
		$refTarget = ClassRegistry::createReflection(get_class($newobj), $newobj);

		foreach ($this->columnDefs as $def) {
			$member = ($def->getAlias()) ? $def->getAlias() : $def->getName();
			$value = SQLValue::importValue($sqlObject[$member], $def);
			$refTarget->set_as_mixed((string)$member, $value);
		}
		return $newobj;
	}

	/**
	 * @param mixed[] $sqlObject
	 * @return array
	 */
	public function readSqlAsArray(array $sqlObject): array
	{
		$named = [];
		foreach ($this->columnDefs as $def) {
			$member = ($def->getAlias()) ? $def->getAlias() : $def->getName();
			$value = SQLValue::importValue($sqlObject[$member], $def);
			$named[$member] = $value;
		}
		return $named;
	}

	/**
	 * @param array $sqlArray
	 * @return IDataObject
	 */
	public function readSqlArray(array &$sqlArray): IDataObject
	{
		$classDeclared = function ($newObj){
			if  (IsKPHP::$isKPHP) return "";
			$s = "(file)";
#ifndef KPHP
			$ref = new \ReflectionClass($newObj);
			$s = $ref->getFileName() . ':' . $ref->getStartLine();
#endif
			return $s;
		};



		$useIndex = false;
		if (is_numeric(array_first_key($sqlArray))) {
			$useIndex = true;
		}
		$newobj = $this->object->createSelf();
		if ( get_class($newobj) != get_class($this->object)) {
			throw new DatabaseArgumentException("Method ".get_class($this->object).'::createSelf() not declared in '.$classDeclared($this->object));
		}
		$pos = 0;

		$errors= [];
		foreach ($this->columnDefs as $idx => $def) {
			$member = $def->getAliasOrName();
			$index = $useIndex ? $pos++ : $member;
			$value = SQLValue::importValue($sqlArray[$index], $def);
			if ( $newobj instanceof DBArrayResult) {
				$newobj->importValue((string)$member, $value);
			}
			else if ( 1 || IsKPHP::$isUseReflection)
			{
#ifndef KPHP
				if ( DBSettings::$isCheckMembers) {
					//check member exists in target object.
					//because KPHP uses switch for declared members, and member MUST be declared
					if (!property_exists($newobj, $member)) {
						$errors[] = 'public ?' . self::gettype($value) . " \$$member = null; ";
						//DataSourceLogger::getInstance()->warning(get_class($newobj)."::$member not declared in class. skip set value.");
					}
				}
#endif

				$columnKey = $def->columnKey();
				if  ( $columnKey) {
					$rc = $newobj->importValueByKey($columnKey, $value);
					if  (!$rc)
					{
						//fallback to use name
						$newobj->importValue((string)$member, $value);
					}
#ifndef KPHP
					if ( DBSettings::$isCheckMembers) {
						if ($value != ($newobj->{$member})) {
							throw new DatabaseException("Invalid $member index = {$columnKey} rc=$rc. may be duplicated");
						}
					}
#endif
				}
				else
				{
					$newobj->importValue((string)$member, $value); //KPHP: 0.03s , PHP: 7.0s
				}
			}
			else {
#ifndef KPHP
				//check member exists in target object.
				//because KPHP uses switch for declared members, and member MUST be declared
				if  (property_exists($newobj, $member)) {
					$newobj->{$member} = $value; //PHP: 1.3s
				}
				else {
					$errors[] = 'public ?'.self::gettype($value)." \$$member = null; ";
					//DataSourceLogger::getInstance()->warning(get_class($newobj)."::$member not declared in class. skip set value.");
				}
#endif
			}
		}
		if  (count($errors)) {
			throw new DatabaseArgumentException(
				"Several properties not declared in " . get_class($newobj)
				. " class, in ".$classDeclared($newobj) ." please fix it:\n"
				. implode("\n", $errors) . "\n\n");
		}
		return $newobj;
	}

	/**
	 * @param mixed $value
	 * @kphp-template T
	 * @kphp-param T $value
	 * @return string
	 */
	private static function gettype($value):string
	{
		if (is_int($value)) return "int";
		if (is_bool($value)) return "bool";
		if (is_float($value)) return "float";
		return gettype($value);
	}

	public function isJoined(SQLJoin $anotherJoin)
	{
		/** @var SQLJoin $join */
		foreach ($this->joins as $join) {
			if ($join->ownerTag->equals($anotherJoin->ownerTag) &&
				$join->foreignTag->equals($anotherJoin->foreignTag)) {
				return true;
			}
		}
		return false;
	}

	/** Indicates whether object was joined by tag
	 * @param IDBColumnDefinition $def
	 * @return bool
	 */
	public function isJoinedByTag(IDBColumnDefinition $def)
	{
		foreach ($this->joins as $join) {
			if ($join->foreignTag->equals($def)) {
				return true;
			}
		}
		return false;
	}

	public function addHaving(IExpression $expr)
	{
		$this->having = $expr;
	}


	public function __toString()
	{
#ifndef KPHP
		return SqlPrint::call("SELECT", [
			SqlPrint::call("columns", $this->columnDefs),
			SqlPrint::call("where", [$this->expr]),
		]);
#endif
		/** @noinspection PhpUnreachableStatementInspection */
		return "(kphp)";

	}
}

