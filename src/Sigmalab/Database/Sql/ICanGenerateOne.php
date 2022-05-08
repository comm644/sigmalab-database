<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Expressions\IExpression;

interface ICanGenerateOne extends IExpression
{
	/** Generate SQL code for defined column in SQL
	 *
	 * @param SQLGenerator $generator
	 * @param int $cause cause of generation, see:
	 * @return string
	 * @see \Sigmalab\Database\Core\DBGenCause
	 */
	public function generate(SQLGenerator $generator, int $cause = 0): string;
}