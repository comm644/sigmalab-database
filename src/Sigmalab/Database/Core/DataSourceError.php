<?php
declare(strict_types=1);

namespace ADO\src\Sigmalab\Database\Core;

class DataSourceError
{
	public const DS_SUCCESS = 0;
	public const DS_ERROR = 1;
	public const DS_CANT_CONNECT = 2;
	public const DS_CANT_SELECT_DB = 3;
	public const DS_METHOD_DOESNT_SUPPORTED = 4;

}