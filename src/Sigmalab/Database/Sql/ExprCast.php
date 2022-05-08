<?php
declare(strict_types=1);

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\Expressions\ECompilerSQL;
use Sigmalab\Database\Expressions\ICanCompileExpression;
use Sigmalab\Database\Expressions\IExpression;

class ExprCast implements ICanGenerateOne, ICanCompileExpression

{
	public string  $type = '';
	public IExpression $value;

	/**
	 * ExprCast constructor.
	 * @param string $type
	 * @param IExpression $value
	 * @see DBParamType
	 */
	public function __construct(string $type, IExpression $value)
	{
		$this->type = $type;
		$this->value = $value;
	}

	/** Generate SQL code for defined column in SQL
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause cause of generation, see:
	 * @return string
	 * @see \Sigmalab\Database\Core\DBGenCause
	 */
	public function generate(SQLGenerator $generator, $cause = 0): string
	{
		$compiler = new ECompilerSQL($generator);
		$compiler->generationMode = DBGenCause::Where;

		$dic = $generator->getDictionary();
		$parts = array(
			$generator->getDictionary()->sqlCast,
			$generator->getDictionary()->sqlOpenFuncParams,
			$compiler->compile($this->value, $this->type),
			$generator->generateTypeCastTo($this->type),
			$generator->getDictionary()->sqlCloseFuncParams
		);
		return implode("", $parts);
	}

	public function compile(ECompilerSQL $compiler): string
	{
		return $this->generate($compiler->generator, $compiler->generationMode);
	}


	public function __toString(): string
	{
		return "Cast type={$this->type}" .
			"\n   ($this->value)";
	}

}