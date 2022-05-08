<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBResultContainer;
use Sigmalab\Database\Core\IDataObject;


/**result container for working with SQLStatementSelect
 */
class SQLStatementSelectResult extends DBResultContainer
{
	/**
	 * Owner statement
	 *
	 * @var SQLStatementSelect
	 */
	protected SQLStatementSelect $stm;
	protected bool $signUseID;


	public function __construct(SQLStatementSelect $stm, bool $signUseID)
	{

		$this->stm = $stm;
		$this->signUseID = $signUseID;
	}

	/**
	 * @param array|mixed[] $sqlLine
	 * @return IDataObject
	 */
	public function fromSQL(array $sqlLine) :IDataObject
	{
		if (is_array($sqlLine)) {
			return $this->stm->readSqlArray($sqlLine);
		} else {
			return $this->stm->readSqlObject($sqlLine);
		}
	}

	/**
	 * Add row as object to result.
	 *
	 * @param IDataObject $object
	 */
	public function add(IDataObject $object): void
	{
		if ($this->signUseID) {
			$pos = $this->getKey($object);
			$this->data[$pos] = $object;
		} else {
			$this->data[] = $object;
		}
	}

	public function getKey(IDataObject $obj): int
	{
		return $obj->primary_key_value();
	}

	/**
	 * @return SQLStatementSelect
	 */
	public function getStatement(): SQLStatementSelect
	{
		return $this->stm;
	}

	public function parseResult(array $sqlRows)
	{
		$this->begin();;
		foreach ($sqlRows as $sqlRow) {
			$this->add( $this->fromSQL((array)$sqlRow) );
		}

		$this->end();;
	}
}


