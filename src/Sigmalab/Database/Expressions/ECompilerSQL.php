<?php
declare(strict_types=1);

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBParam;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Sql\ICanGenerateOne;
use Sigmalab\Database\Sql\SQLDic;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLValue;

class ECompilerSQL
{
	public const EMPTY = "";

	/**
	 * SQL dictionary
	 *
	 * @var SQLDic
	 */
	public SQLDic $sqlDic;


	/**
	 * SQL Geenrator instance
	 *
	 * @var SQLGenerator
	 */
	public ?SQLGenerator $generator = null;


	/**
	 * Indicates wheter method compile() returns parametrized query.
	 *
	 * @var bool
	 */
	public bool $isParametrized = false;

	/**
	 * Param index for constructing name
	 *
	 * @var int
	 */
	public int $paramIndex = 0;

	/**
	 *  Array of constructed params
	 * @var DBParam[]
	 */
	public array $params = array();
	/**
	 * @var int
	 */
	public int $generationMode = DBGenCause::Columns;

	public array $modeStack = [];


	/**
	 * Initialize new copy of ECompilerSQL
	 *
	 * @param SQLGenerator $generator
	 * @param bool $isParametrized
	 */
	public function __construct($generator, bool $isParametrized = false)
	{
		$this->sqlDic = $generator->getDictionary();
		$this->generator = $generator;
		$this->isParametrized = $isParametrized;
	}

	/**
	 * Gets compiled parameters
	 * @return array(DBParam)
	 */
	public function getParameters()
	{
		return $this->params;
	}


	/**
	 * group expressions
	 *
	 * @param string $query
	 * @return string
	 */
	public function sqlGroup($query)
	{
		return "({$query})";
	}

	public static function s_sqlGroup(string $query)
	{
		return "({$query})";
	}


	public function createParamName():string
	{
		$name = $this->generator->generatePlaceHolderName('p' . $this->paramIndex);
		$this->paramIndex++;
		return $name;
	}

	/**
	 * Generate SQL Value or placeholder
	 * @param SQLValue $expr
	 * @return string
	 */
	public function compileValue(SQLValue $expr)
	{
		$exprValue = $expr->value;
		if (!$this->isParametrized) {
//#ifndef KPHP
//			if  ($exprValue instanceof IExpression) {
//				//wrapped
//				return $exprValue->compileExpression($this);
//			}
//			if  ($exprValue instanceof SQLValue) {
//				//wrapped
//				return $exprValue->compileExpression($this);
//			}
//			if  ($exprValue instanceof ICanGenerateOne) {
//				//wrapped
//				return $exprValue->generate($this->generator);
//			}
//#endif
			return ($expr->compileExpression($this));
		}
		$name = $this->createParamName();

		$this->params[] = new DBParam($name,
			SQLValue::getDbParamType($exprValue, $expr->type),
			SQLValue::getDbParamValue($exprValue, $expr->type, $this->generator));
		return $name;
	}

	public function compileLike(string $name, string $value):string
	{
		if (!$this->isParametrized) {
			return $this->generator->generateLikeCondition($name, $value);
		}
		$pholder = $this->createParamName();

		$this->params[] = new DBParam($pholder,
			SQLValue::getDbParamType($value),
			$this->generator->generateSearchString($value));

		return "$name LIKE $pholder";
	}

	/**
	 * @param  IExpression $expr
	 * @param string|null $type DBValueType
	 * @return string
	 * @throws DatabaseArgumentException
	 */
	public function compile(IExpression $expr, ?string $type = null):string
	{
		if ( $expr instanceof SQLValue) {
			/** @noinspection PhpParamsInspection */
			return $this->compileValue(instance_cast($expr, SQLValue::class));
		}

		if ($expr instanceof SQLName) {
			$genName = instance_cast($expr, ICanGenerateOne::class);
			return ($genName->generate($this->generator, $this->generationMode));
		}

		if ($expr instanceof DBColumnDefinition) {
			$exprColumn = instance_cast($expr, DBColumnDefinition::class);
			$sqlName = new SQLName($exprColumn->getTableAlias(), $exprColumn->getName());
			return ($sqlName->generate($this->generator));
		}

		if( $expr instanceof ICanCompileExpression) {
			/** @var ICanCompileExpression $exprCompile */
			$exprCompile = instance_cast($expr, ICanCompileExpression::class);
			return $exprCompile->compile($this);
		}

		if (!($expr instanceof SQLExpression)) {
			throw new DatabaseArgumentException("Is not expression subclass given. Got: " . get_class($expr));
		}
		return ECompilerSQL::EMPTY;
	}

	/**
	 * @param ICanGenerateOne $name
	 * @return string
	 */
	public function getName(ICanGenerateOne $name)
	{
		return $name->generate($this->generator, $this->generationMode);
	}


	/**
	 * compile Expression
	 *
	 * @param  IExpression $expr expression
	 * @param SQLGenerator $generator SQL generator.
	 * @return string  compiled SQL query
	 */
	public static function s_compile(&$expr, $generator)
	{
		$compiler = new ECompilerSQL($generator);
		return ($compiler->compile($expr));
	}

	/**
	 * @param int $mode DBGenCause
	 */
	public function pushMode(int $mode)
	{
		$this->modeStack[]= $this->generationMode;
		$this->generationMode = $mode;
	}
	public function popMode():void
	{
		$this->generationMode = array_pop($this->modeStack);
	}
}
