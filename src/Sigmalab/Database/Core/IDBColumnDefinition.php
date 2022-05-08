<?php

namespace Sigmalab\Database\Core;

use Sigmalab\Database\Sql\ICanGenerateOne;
use Sigmalab\SimpleReflection\IReflectedObject;

/**
 * This class defines meta information about database column.
 *
 * Usually in generated code this class used as return valie in tag_*() methods.
 */
interface IDBColumnDefinition
	extends ICanGenerateOne, IReflectedObject

{
	/**
	 * Gets column name. Methods retuns raw column name.
	 *
	 * @return string|null
	 */
	public function getName(): ?string;

	/**
	 * Gets column alias if defined.
	 * If column alias is not defined then method returns column name.
	 *
	 * @return string|null ?string
	 */
	public function getAlias(): ?string;

	/**
	 * Gets alias or name for binding destination column name.
	 * Main idea is : value in result set can be binded to another member.
	 * member name in this case need set by Alias, another words, column name
	 * always have using as member name.
	 *
	 * @return string|null
	 */
	public function getAliasOrName();

	/**
	 * Gets table alias.
	 * Method returns table alias if alias defined. If table alias is not defined
	 * then method returns table name.
	 *
	 * If table not defined for column then method returns null
	 *
	 * @return string|null ?string  table alias
	 */
	public function getTableAlias(): ?string;

	/**
	 * Gets raw table name.
	 *
	 * @return string|null ?string
	 */
	public function getTableName(): ?string;

	public function equals(IDBColumnDefinition $tag);

	/** @return bool */
	public function isNullable();

	/** @return string
	 * @see DBValueType
	 */
	public function getType();

	/** Indicates that column already aggregated.
	 * @return bool
	 */
	public function isAggregated(): bool;

	/** Get column key for faster access method by index  */
	public function columnKey(): int;
}