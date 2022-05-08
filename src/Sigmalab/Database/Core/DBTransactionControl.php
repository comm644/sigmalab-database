<?php

namespace Sigmalab\Database\Core;

use Sigmalab\Database\DatabaseBusyException;
use Sigmalab\Database\DatabaseException;

trait DBTransactionControl
{
	private int $transactionLevel = 0;
	private float $transactionStartTime = 0;
	private string $uid = "";

	protected abstract function linkCommitTransaction(): void;

	protected abstract function linkRollbackTransaction(): void;

	protected abstract function linkBeginTransaction(): void;

	/**
	 * Gets logger object.
	 * @return DataSourceLogger  logger instance
	 * @access protected
	 */
	protected abstract function getLogger();

	public function inTransaction(): bool
	{
		return $this->transactionLevel > 0;
	}


	/**
	 * @throws DatabaseBusyException
	 * @throws DatabaseException
	 */
	public function beginTransaction()
	{
		if ($this->transactionLevel === 0) {
			$this->transactionStartTime = microtime(true);
			$this->linkBeginTransaction();;
		}
		$this->transactionLevel++;
	}

	/**
	 * @throws \Exception
	 */
	public function commitTransaction()
	{
		if  ($this->transactionLevel < 0) return;

		$this->transactionLevel--;
		if ($this->transactionLevel !== 0) return;

		$this->linkCommitTransaction();
		$this->getLogger()->notice("Transaction time: " . (microtime(true) - $this->transactionStartTime));
	}

	public function rollbackTransaction()
	{
		$this->linkRollbackTransaction();;
		$this->transactionLevel = 0;
	}
}