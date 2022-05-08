<?php

namespace Sigmalab\Database\Expressions;

/**
 * Raw condition. Do not use it.
 *
 */
class ExprRaw extends SQLExpression
{
	/**
	 * raw condition
	 *
	 * @var string
	 */
	public string $raw = '';

	/**
	 * construct expresion
	 *
	 * @param string $rawCondition
	 */
	public function __construct(string $rawCondition)
	{
		$this->raw = $rawCondition;
		parent::__construct("", null);
	}

	public function compile(ECompilerSQL $compiler): string
	{
		return $this->raw;
	}
}