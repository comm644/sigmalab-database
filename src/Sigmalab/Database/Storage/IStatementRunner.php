<?php

namespace Sigmalab\Database\Storage;

use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Sql\SQLStatement;

/**
 * Interface IStatementRunner provides abstract access to Database interaction level.
 */
interface IStatementRunner
{
	/**
	 * Execute statement and return result as return value.
	 *
	 * @param SQLStatement $stm Statement.
	 * @return IDataObject[]  result set of objects or last ID.
	 * @throws \Sigmalab\Database\DatabaseException
	 */
	public function execute(SQLStatement $stm): array;
}