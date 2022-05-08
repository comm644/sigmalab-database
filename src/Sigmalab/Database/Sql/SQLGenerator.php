<?php


namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBQuery;

abstract class SQLGenerator
{
	/**
	 * SQL dictionary
	 *
	 * @var SQLDic
	 */
	protected SQLDic $_dictionary;

	/** construct generator
	 * @param SQLDic $dictionary
	 */
	public function __construct(?SQLDic $dictionary = null)
	{
		if (!$dictionary) $dictionary = new SQLDic();

		$this->_dictionary = $dictionary;
	}

	/**
	 * Get SQL dictionary.
	 */
	public function getDictionary():SQLDic
	{
		return $this->_dictionary;
	}

	/** generate sql column defintion from mixed variable fow function argument and Where clause
	 *
	 * @param ICanGenerateOne $column
	 * @param string|null $defaultTable default name.
	 * @return string
	 */
	public function generateColumn(ICanGenerateOne $column, ?string $defaultTable = null): string
	{
		return $column->generate($this, DBGenCause::Where);
	}

	/**
	 * @param ICanGenerateOne $column
	 * @return string
	 */
	public function generateName(ICanGenerateOne $column)
	{
		return $column->generate($this);
	}

	/**
	 * @param mixed $value
	 * @return string
	 */
	public function generateValueAsBLOB(&$value): string
	{
		//mysql
		return ("0x" . bin2hex($value));
	}

	/**
	 * Generate place holder name.
	 *
	 * @param string $name base name
	 * @return string  real place holder name
	 */
	public function generatePlaceHolderName($name)
	{
		return ':' . $name;
	}


	/**
	 * Generate statement SQL query
	 * @param \Sigmalab\Database\Sql\SQLStatement $stm
	 * @return string
	 */
	public function generate(SQLStatement $stm): string
	{
		return $stm->generate($this);
	}

	/**
	 * Generate parametrized query.
	 * Use this method for insert and update opration bacause BLOBs via parameter have better transfer speed.
	 * returns   rendred query object
	 *
	 * @param SQLStatement $stm
	 *
	 * @return DBQuery
	 */
	public function generateParametrizedQuery(SQLStatement $stm): DBQuery
	{
		return $stm->generateQuery($this);
	}

	/**
	 * Generate SQL DateTime value
	 * @param int $value unix time
	 * @return string  SQL92 Date time
	 */
	public function generateDateTime(int $value): string
	{
		return (date("Y-m-d H:M:S", $value));
	}

	/**
	 * Generate SQL Date value
	 * @param int $value unix time
	 * @return string  SQL92 Date time
	 */
	public function generateDate(int $value): string
	{
		return (date("Y-m-d", $value));
	}

	/**
	 * Escape string for using in non-compileable SQL requestes.
	 * for PDO implement as dummy method.
	 *
	 * @param string $value
	 * @return string   escaped string.
	 */
	public abstract function escapeString(string $value): string;

	/**
	 * Generarte LIKE condition
	 *
	 * @param string $name column name
	 * @param string $value value string without 'any string' instructions
	 * @return string constructed expression
	 */
	public function generateLikeCondition($name, $value)
	{
		$value = $this->escapeString($value);
		return ("{$name} LIKE '%{$value}%'");
	}

	/**
	 * Generate search string. escape string if need and wrap to '%' or
	 * another according to database
	 *
	 * @param string $value
	 * @return string
	 */
	public function generateSearchString($value)
	{
		$value = $this->escapeString($value);
		return ("%" . $value . "%");
	}

	/** some databases does not have support LIMIT for UPDATE Statement.
	 */
	public function updateLimitEnabled(): bool
	{
		return true;
	}

	/** Generate type info
	 * @seealso  DBValueType
	 */
	public function generateTypeCastTo(string $type): string
	{
		return '';
	}
}

