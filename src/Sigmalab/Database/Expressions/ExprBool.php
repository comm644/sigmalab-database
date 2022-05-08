<?php
declare(strict_types=1);

namespace Sigmalab\Database\Expressions;

use Sigmalab\Database\Core\DBColumnDefinition;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\DatabaseArgumentException;
use Sigmalab\Database\Discovery\SqlPrint;
use Sigmalab\Database\Sql\ICanGenerateOne;
use Sigmalab\Database\Sql\SQLValue;

/** bool expression
 */
class ExprBool extends SQLExpression
{
	/**
	 * @var IDBColumnDefinition
	 */
	public IDBColumnDefinition $name;

	/**
	 * ExprBool constructor.
	 * @param string $mode
	 * @param IDBColumnDefinition $name
	 * @param IExpression[] $values
	 */
	public function __construct(string $mode, IDBColumnDefinition $name, array $values)
	{
		parent::__construct($mode, $values);

		$this->name = $name;
		$this->type = $name->getType();
	}

	public function compile(ECompilerSQL $compiler): string
	{
		$pos = 0;
		$query = ECompilerSQL::EMPTY;

		if ($this->mode === "IS") {
			$query .= $compiler->getName($this->name) . ' ' . $this->mode . ' NULL';
		} else if ($this->mode === "IS NOT") {
			$query .= $compiler->getName($this->name) . ' ' . $this->mode . ' NULL';
		} else {
			$parts = array();

			foreach ($this->args as $arg) {
				if ($pos > 0) $parts[] = $compiler->sqlDic->sqlAnd;
				$parts[] = $compiler->getName($this->name);
				$parts[] = $this->mode;
				if ($arg instanceof DBColumnDefinition) {
					$parts[] = $compiler->compile($arg, $this->type);
				} else if ($arg instanceof SQLValue) {
					$parts[] = $compiler->compileValue($arg); //need for parameters
				} else if ($arg instanceof ICanGenerateOne) {
					$parts[] = $arg->generate($compiler->generator);
				} else if ($arg instanceof IExpression) {
					$parts[] = $compiler->compile($arg, $this->type);
				} else if (is_object($arg)) {
					throw new DatabaseArgumentException("Cant compile type:" . get_class($arg));
				}
//#ifndef KPHP
//				else if (is_scalar($arg) || is_null($arg)) {
//					$parts[] = $compiler->compile(new SQLValue($arg, $this->type), $this->type);
//				}
//#endif
				else {
					$argType = "(kphp)";
#ifndef KPHP
					/** @noinspection SuspiciousAssignmentsInspection */
					$argType = gettype($arg);
#endif
					throw new DatabaseArgumentException("Cant compile type:" . $argType);
				}
				$pos++;
			}
			$query .= implode(' ', $parts);
		}
		return ($compiler->sqlGroup($query));
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
#ifndef KPHP
		return SqlPrint::call("Expr{$this->mode}  type=$this->type argsCount=" . count($this->args),
			array_merge([$this->name], $this->args));
#endif
		/** @noinspection PhpUnreachableStatementInspection */
		return "(kphp)";
	}

}