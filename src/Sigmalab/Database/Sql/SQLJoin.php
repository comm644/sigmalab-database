<?php

namespace Sigmalab\Database\Sql;

use Sigmalab\Database\Core\DBForeignKey;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQx;
use Sigmalab\Database\Expressions\IExpression;

/**
 * This class incapsulates easy joining tables engine.
 *
 * You no need think about "how to join tables". Just amek join tables via
 * column pair or foreign key.  All DBObject objects already contains
 * all necessary metadata for joining.
 */
class SQLJoin
{

	/**
	 * tag from owner object
	 * @var IDBColumnDefinition
	 */
	public IDBColumnDefinition $ownerTag;

	/**
	 * tag from fereign object
	 * @var IDBColumnDefinition
	 */
	public IDBColumnDefinition $foreignTag;

	/**
	 * user expression for join
	 * @var  IExpression
	 */
	public ?IExpression $expr = null;


	private function __construct()
	{
	}

	/**
	 * Construct join for specified forign key.
	 *
	 * @param DBForeignKey $key
	 * @param IDataObject $ownerObject owner object for detecting base table.
	 * @return SQLJoin
	 */
	public static function createByKey(DBForeignKey $key, IDataObject $ownerObject = null): self
	{
		$join = new SQLJoin();
		if (get_class($key) != DBForeignKey::class) {
			throw new \Exception(sprintf("'Key' parameter must be DBForeignKey type, but got '%s'", get_class($key)));
		}

		if ($ownerObject && $ownerObject->table_name() != $key->ownerTag->getTableName()) {
			$join->ownerTag = $key->foreignTag;
			$join->foreignTag = $key->ownerTag;
		} else {
			$join->ownerTag = $key->ownerTag;
			$join->foreignTag = $key->foreignTag;
		}

		return ($join);
	}

	/**
	 *  Construct Jon by column pair.
	 *
	 * @param IDBColumnDefinition $ownerTag owner object column
	 * @param IDBColumnDefinition $foreignTag join object column
	 * @param IExpression|null $expr
	 * @return SQLJoin
	 */
	public static function createByPair(
		IDBColumnDefinition $ownerTag, IDBColumnDefinition $foreignTag, ?IExpression $expr = null)
	{
		$join = new SQLJoin();
		$join->ownerTag = $ownerTag;
		$join->foreignTag = $foreignTag;
		if ($expr) {
			$join->addExpression($expr);
		}
		return ($join);

	}

	/**
	 * Create by key strictly. without smart logic.
	 * @param DBForeignKey $key
	 * @return SQLJoin
	 */
	public static function createByMasterKey(DBForeignKey $key)
	{
		$join = new SQLJoin();
		$join->ownerTag = $key->ownerTag();
		$join->foreignTag = $key->foreignTag();
		return ($join);
	}

	/**
	 * Create by key strictly. without smart logic.
	 * @param DBForeignKey $key
	 * @return SQLJoin
	 */
	public static function createBySlaveKey(DBForeignKey $key)
	{
		$join = new SQLJoin();
		$join->ownerTag = $key->foreignTag();
		$join->foreignTag = $key->ownerTag();
		return ($join);
	}

	/**
	 * Add expression for Join.
	 *
	 * @param IExpression $expr
	 * @return SQLJoin
	 */
	public function addExpression(IExpression $expr)
	{
		$this->expr = $expr;
		return $this;
	}

	public function generate(SQLGenerator $generator)
	{
		$sql = $generator->getDictionary();

		$parts = array();

		$foreignTag = $this->foreignTag;
		$tableName = new SQLAlias(
			$foreignTag->getTableName(),
			'',
			(string)$foreignTag->getTableAlias());

		/** @var IExpression $expr */
		$expr = new ExprEQx($foreignTag, $this->ownerTag);

		if (!is_null($this->expr)) {
			$expr = new ExprAND([$expr, $this->expr]);
		}

		$parts[] = $sql->sqlLeftJoin;
		$parts[] = $tableName->generate($generator);
		$parts[] = $sql->sqlOn;

		$parts[] = SQL::compileWhereExpr($expr, $generator);

		return (implode(" ", $parts));
	}
}

