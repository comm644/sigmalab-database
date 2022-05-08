<?php

namespace Sigmalab\Database\Expressions;

interface ICanCompileExpression
{
	public function compile(ECompilerSQL $compiler): string;
}