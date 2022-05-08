<?php


namespace Sigmalab\Database\Core;


class DBCommandContainer extends DBDefaultResultContainer
{
	public function __construct()
	{
		parent::__construct(new DBRowsAffectedResult(), false);
	}
}