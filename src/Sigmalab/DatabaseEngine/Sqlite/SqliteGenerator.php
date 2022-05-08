<?php

namespace Sigmalab\DatabaseEngine\Sqlite;

use Sigmalab\Database\Core\DBParamType;
use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Sql\SQLDic;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementInsert;

require_once(__DIR__ . '/SqliteDictionary.php');


class SqliteGenerator extends SQLGenerator
{
	public function __construct($dic = null)
	{
		parent::__construct($dic);
		$this->_dictionary = new SqliteDictionary();
	}

	/**
	 * returns dictionary
	 */
	public function getDictionary(): SQLDic
	{
		return $this->_dictionary;
	}

	public function generateInsert(SQLStatementInsert $stm):string
	{
		$tname = new SQLName($stm->table, null);

		$sql = $this->getDictionary();

		$parts = array();
		$parts[] = $stm->sqlStatement;
		$parts[] = $tname->generate($this);

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = $stm->_getColumns($this);
		$parts[] = $sql->sqlCloseFuncParams;

		$parts[] = $sql->sqlValues;

		$parts[] = $sql->sqlOpenFuncParams;
		$parts[] = $stm->_getValues($this);
		$parts[] = $sql->sqlCloseFuncParams;

		return ((string)implode(" ", $parts));
	}

	public function generate(SQLStatement $stm): string
	{
		if ($stm instanceof SQLStatementInsert) {
			return $this->generateInsert($stm);
		}
		return parent::generate($stm);
	}

	public function generateValueasBLOB(&$value): string
	{
		//mysql
		return ("X'" . bin2hex($value) . "'");
	}

	/** convert unit-time to ISO8601 format. "yyyy-MM-ddTHH:mm:ss.SSS"
	 */
	public function generateDateTime($value): string
	{
		return date('Y-m-d\TH:i:S', $value);
	}

	/**
	 * for PDO returns same string. because PDO can escape by the way.
	 * @param string $value
	 */
	public function escapeString(string $value): string
	{
		return $value;
	}

	public function updateLimitEnabled(): bool
	{
		return false;
	}

	public function generateTypeCastTo(string $type): string
	{
		switch ($type) {
			case DBValueType::Integer:
				return " as int";
			case DBValueType::String:
				return " as text";
			case DBValueType::Real:
				return " as float";
			case DBValueType::Datetime:
				return " as datetime";
		}
		return '';
	}
}