<?php

namespace Sigmalab\DatabaseEngine\Postgre;

use Sigmalab\Database\Sql\SQLDic;

/**
 * Created by PhpStorm.
 * User: comm
 * Date: 13.02.17
 * Time: 1:14
 */
class PostgreDictionary extends SQLDic
{
	public function __construct()
	{
		$this->sqlOpenName = "\"";
		$this->sqlCloseName = "\"";
		$this->sqlOpenTableName = "";
		$this->sqlCloseTableName = "";
		$this->sqlStringOpen = '\'';
		$this->sqlStringClose = '\'';
		$this->sqlCast = ""; //used direct cast ::type
	}
}