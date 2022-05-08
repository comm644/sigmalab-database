<?php

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Discovery\SqlPrint;
use Sigmalab\Database\Sql\SQLValue;

class ExprIN extends ExprSet
{
	/**
	 * @var IDBColumnDefinition
	 */
	public IDBColumnDefinition $name;

	/**
	 * ExprIN constructor.
	 * @param IDBColumnDefinition $name
	 * @param mixed $values
	 */
	public function __construct(IDBColumnDefinition $name, array $values)
	{
		if ( count($values) == 0) throw new DatabaseArgumentException("Value for IN cannot be empty");
		parent::__construct("IN", array_map(function ($x) use ($name) {
			return new SQLValue($x, $name->getType());
		}, $values));
		$this->name = $name;
		$this->type = $name->getType();
	}


	public function compile(ECompilerSQL $compiler): string
	{
		if (count($this->args) == 0) return ECompilerSQL::EMPTY; //empty set

		$signTestNull = false;
		$parts = array();
		foreach ($this->args as $arg) {
			/** @noinspection PhpParamsInspection */
			$text = $compiler->compile(instance_cast($arg, SQLValue::class));
			if ($text == "NULL") {
				$signTestNull = true;
				continue;
			}
			$parts[] = $text;
		}


		if (count($parts) == 0) {
			if (!$signTestNull) return (ECompilerSQL::EMPTY); //empty set

			//null only
			$query = $compiler->getName($this->name) . " {$compiler->sqlDic->sqlIsNull}";
			return ($query);
		}
		//other values

		$query = "{$compiler->getName( $this->name )} {$this->mode} ";
		$query .= $compiler->sqlGroup(implode(",", $parts));

		if ($signTestNull) {
			$query .= " {$compiler->sqlDic->sqlAnd} " . $compiler->getName($this->name) . " {$compiler->sqlDic->sqlIsNull}";
		}
		return ($query);
	}

	public function __toString(): string
	{
		return SqlPrint::call("Expr{$this->mode} name={$this->name} type=$this->type argsCount=" . count($this->args), $this->args);
	}

}