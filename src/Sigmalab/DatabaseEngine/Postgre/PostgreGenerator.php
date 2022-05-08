<?php

namespace Sigmalab\DatabaseEngine\Postgre;

use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Sql\SQLGenerator;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementInsert;

require_once(__DIR__ . '/PostgreDictionary.php');


class PostgreGenerator extends SQLGenerator
{
	public function __construct($dictionary = null)
	{
		parent::__construct(new PostgreDictionary());
		$this->_dictionary = new PostgreDictionary();
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

		return (implode(" ", $parts));
	}

	/**
	 *@inheritDoc
	 */
	public function generate(SQLStatement $stm) :string
	{
		if ( $stm instanceof SQLStatementInsert) {
			return $this->generateInsert($stm);
		}
		return parent::generate($stm);
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	public function generateValueasBLOB(&$value): string
	{
		//mysql
		return ("X'" . bin2hex($value) . "'");
	}

	/** convert unit-time to ISO8601 format. "yyyy-MM-ddTHH:mm:ss.SSS"
	 */
	public function generateDateTime($value): string
	{
		return (string)strftime('%Y-%m-%dT%H:%M:%S', $value);
	}

	/**
	 * for PDO returns same string. because PDO can escape by the way.
	 * @param string $value
	 */
	public function escapeString(string $value) :string
	{
		return $value;
	}

	/** @noinspection PhpMissingParentCallCommonInspection */
	public function updateLimitEnabled(): bool
	{
		return false;
	}

	public function generateTypeCastTo(string $type): string
	{
		switch ($type) {
			case DBValueType::Integer:
				return "::int";
			case DBValueType::String:
				return "::text";
		}
		return '';
	}

}