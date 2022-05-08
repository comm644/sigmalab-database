<?php

namespace Sigmalab\DatabaseEngine\Mysql;

use Sigmalab\Database\Sql\SQLDic;

class MysqlDictionary extends SQLDic
{
	//http://dev.mysql.com/doc/refman/5.0/en/char.html
	public string $sqlStringOpen = '\'';
	public string $sqlStringClose = '\'';
}