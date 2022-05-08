<?php

namespace Sigmalab\DatabaseEngine\Mysql;

use Sigmalab\Database\Sql\SQLDic;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\DatabaseEngine\Sqlite\SqliteDictionary;

class MysqlGenerator extends SQLGenerator
{
	/**
	 * dictionary
	 */
	protected SQLDic $_dictionary;

	public function __construct()
	{
		$this->_dictionary = new MysqlDictionary();
		parent::__construct($this->_dictionary);
	}

	/**
	 * returns dictionary
	 */
	public function getDictionary():SQLDic
	{
		return $this->_dictionary;
	}

	/**
	 * Escape string for using in non-compileable SQL requestes.
	 *
	 * @param string $value
	 * @return string
	 */
	public function escapeString(string $value): string
	{
		return MysqlDataSource::escapeString($value);
	}
}