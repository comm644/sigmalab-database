<?php

class SqlTestGenerator extends \Sigmalab\Database\Sql\SQLGenerator
{

	/**
	 * @inheritDoc
	 */
	public function escapeString(string $value): string
	{
		return $value;
	}
}