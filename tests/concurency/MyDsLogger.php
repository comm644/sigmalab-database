<?php

use Sigmalab\Database\Core\DataSourceLogger;

/**
 * Created by PhpStorm.
 * User: comm
 * Date: 01.06.16
 * Time: 15:20
 */
class MyDsLogger extends DataSourceLogger
{
	public function debug(string $msg): void
	{
		echo($msg);
	}

	public function notice(string $msg): void
	{
		echo($msg);

	}

	public function warning(string $msg): void
	{
		echo($msg);

	}

	public function error(string $msg): void
	{

		echo($msg);
	}
}
DataSourceLogger::setInstance( new MyDsLogger  );
