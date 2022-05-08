<?php

namespace Sigmalab\Database\Sql;
/******************************************************************************
 * Copyright (c) 2007-2021 by Alexei V. Vasilyev.  All Rights Reserved.
 * -----------------------------------------------------------------------------
 * Module     : SQL language dictionary
 * File       : SQLDic.php
 * Author     : Alexei V. Vasilyev
 * -----------------------------------------------------------------------------
 * Description:
 *
 * descibe SQL language keywords.
 * this object should be provided by DataSource
 ******************************************************************************/
class SQLDic
{
	public string $sqlSelect = "SELECT";
	public string $sqlFrom = "FROM";
	public string $sqlWhere = "WHERE";
	public string $sqlLimit = "LIMIT";
	public string $sqlOffset = "OFFSET";

	public string $sqlOrder = "ORDER BY";
	public string $sqlGroup = "GROUP BY";
	public string $sqlAscending = "ASC";
	public string $sqlDescending = "DESC";

	public string $sqlAnd = "AND";
	public string $sqlLike = "LIKE";
	public string $sqlOr = "OR";
	public string $sqlIn = "IN";
	public string $sqlAs = "AS";

	public string $sqlLeftJoin = "\nLEFT JOIN";
	public string $sqlOn = "ON";

	public string $sqlOpenName = "`";
	public string $sqlCloseName = "`";
	public string $sqlOpenTableName = "`";
	public string $sqlCloseTableName = "`";
	public string $sqlTableColumnSeparator = '.';

	public string $sqlStringOpen = '"';
	public string $sqlStringClose = '"';

	public string $sqlInsert = "INSERT INTO";
	public string $sqlValues = "VALUES";

	public string $sqlSet = "SET";

	public string $sqlLikeMaskAny = "%";
	public string $sqlIsNull = "IS NULL";

	public string $sqlOpenFuncParams = "(";
	public string $sqlCloseFuncParams = ")";

	public string $sqlAssignValue = '=';
	public string $sqlHaving = 'HAVING';
	public string $sqlCast = "CAST";
}


