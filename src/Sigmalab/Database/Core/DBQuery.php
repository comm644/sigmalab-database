<?php


namespace Sigmalab\Database\Core;
/**
 * This class incapsulates parametrized SQL query and paremeters which
 * can be assigned to query placeholders.
 *
 */
class DBQuery
{
	/**
	 * Generated query with placeholders.
	 *
	 * @var string
	 * @access private
	 */
	private string $_query;

	/**
	 * Parameters array for query.
	 *
	 * @var DBParam[]
	 * @access private
	 */
	private array $_params;

#ifndef KPHP

	/**
	 * @param mixed $array
	 */
	public static function __set_state($array):self
	{
		$obj = new self('', array());
		foreach ($array as $key => $value) {
			$obj->$key = $value;
		}
		return $obj;
	}
#endif

	/**
	 * Gets query with placeholders.
	 *
	 * @return string
	 */
	public function getQuery()
	{
		return $this->_query;
	}

	/**
	 * Gets parameters array
	 *
	 * @return DBParam[] array of DBParam
	 * @see DBParam
	 */
	public function getParameters():array
	{
		return $this->_params;
	}

	/**
	 * Initializes new instance of DBQuery object.
	 *
	 * @param string $sqlQuery generated SQL parametrized query.
	 * @param DBParam[] $parameters DBParam array.
	 */
	public function __construct(string $sqlQuery, array $parameters)
	{
		$this->_query = $sqlQuery;
		$this->_params = $parameters;
	}

	public function toString():string
	{
		return "query: {$this->_query}. Parameters: ".count($this->_params);
	}
	public function __toString():string
	{
		return $this->toString();
	}
}

