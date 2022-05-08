<?php

use Database\Data;
use Database\Dictionary;
use Sigmalab\Database\Expressions\ExprAND;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Sql\SQL;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\DatabaseEngine\Sqlite\SqliteGenerator;

require_once(__DIR__ . "/tracer.php");
require_once(__DIR__ . "/objects/schema.php");
require_once(__DIR__ . "/../ADO.php");
require_once( __DIR__.'/env.php');

class testSqlSelect extends xUnit_TestSuite
{
	function ws($str)
	{
		return str_replace("\n", "", $str);
	}

	/**
	 * @throws Exception
	 */
	function testSelect_Object()
	{
		$data = new Data();
		$data->setTableAlias("d");

		$stm = new SQLStatementSelect($data);

		$generator = new SqliteGenerator();
		$query = $stm->generate($generator);

		$expected = "SELECT"
			. " `d`.data_id AS data_id,"
			. " `d`.date AS date,"
			. " `d`.value AS value,"
			. " `d`.string AS string,"
			. " `d`.text AS text,"
//			. " `d`.enum AS enum,"
			. " `d`.blob AS blob,"
			. " `d`.real AS real,"
			. " `d`.dictionary_id AS dictionary_id"
			. " FROM `t_data` AS `d`";

		$this->assertEquals($expected, $this->ws($query));
	}

	function testExpressions()
	{
		$data = new Data();
		$data->setTableAlias("d");

		$expr = new ExprAND([
			new ExprEQ($data->tag_value(), 1),
			new ExprEQ($data->tag_date(), 1),
			new ExprEQ($data->tag_string(), ""),
			new ExprEQ($data->tag_text(), ""),
			ExprEQ::isNull($data->tag_text())
		]);
		$expected = ""
			. "((`d`.value = 1)"
			. " AND (`d`.date = '1970-01-01T03:00:01')"
			. " AND (`d`.string = \"\")"
			. " AND (`d`.text = \"\")"
			. " AND (`d`.text IS NULL))";

		$query = SQL::compileWhereExpr($expr, new SqliteGenerator());

		$this->assertEquals($expected, $this->ws($query));
	}
//SELECT `d`.data_id AS data_id, `d`.date AS date, `d`.value AS value, `d`.string AS string, `d`.text AS text, `d`.enum AS enum, `d`.blob AS blob, `d`.real AS real, `d`.dictionary_id AS dictionary_id, `dic`.text AS dic_text1, `dic`.text AS dic_text FROM `t_data` AS `d` LEFT JOIN `t_dictionary` AS `dic` ON (`dic`.dictionary_id = `d`.dictionary_id) WHERE ((`d`.value = 1) AND (`d`.date = \'1970-01-01 03:00:01\') AND (`d`.string = "") AND (`d`.text = "") AND (`d`.text IS NULL)) GROUP BY `d`.date ORDER BY `d`.date ASC'>
//SELECT `d`.data_id AS data_id, `d`.date AS date, `d`.value AS value, `d`.string AS string, `d`.text AS text, `d`.enum AS enum, `d`.blob AS blob, `d`.real AS real, `d`.dictionary_id AS dictionary_id, `dic`.text AS dic_text1, `dic`.text AS dic_text FROM `t_data` AS `d` LEFT JOIN `t_dictionary` AS `dic` ON (`dic`.dictionary_id = `d`.dictionary_id) WHERE ((`d`.value = 1) AND (`d`.date = \'1970-01-01T03:00:01\') AND (`d`.string = "") AND (`d`.text = "") AND (`d`.text = NULL)) GROUP BY `d`.date ORDER BY `d`.date ASC'>

	/**
	 * validate:
	 *
	 * column alias
	 * table alias
	 * join
	 * columns
	 * order
	 */
	function testSelect()
	{
		$data = new Data();
		$data->setTableAlias("d");

		$dic = new Dictionary();
		$dic->setTableAlias("dic");

		$stm = new SQLStatementSelect($data);
		$stm->setExpression(
			new ExprAND([
				ExprEQ::eqInt($data->tag_value(), 1),
				ExprEQ::eqDatetime($data->tag_date(), 1),
				ExprEQ::eqString($data->tag_string(), ""),
				ExprEQ::eqString($data->tag_text(), ""),
				ExprEQ::isNull($data->tag_text())
			]));

		$stm->addOrder($data->tag_date());
		$stm->addGroup($data->tag_date());
		$stm->addColumn($dic->tag_text("dic_text1"));
		$stm->addColumn($dic->tag_text("dic_text")); //same and alias
		$stm->addJoinByKey($data->key_dictionary_id($dic));

		$query = $stm->generate(new SqliteGenerator());

		$expected = "SELECT"
			. " `d`.data_id AS data_id,"
			. " `d`.date AS date,"
			. " `d`.value AS value,"
			. " `d`.string AS string,"
			. " `d`.text AS text,"
//			. " `d`.enum AS enum,"
			. " `d`.blob AS blob,"
			. " `d`.real AS real,"
			. " `d`.dictionary_id AS dictionary_id,"
			. " `dic`.text AS dic_text1,"
			. " `dic`.text AS dic_text"
			. " FROM `t_data` AS `d` "
			. "LEFT JOIN `t_dictionary` AS `dic` ON (`dic`.dictionary_id = `d`.dictionary_id) "
			. "WHERE ((`d`.value = 1)"
			. " AND (`d`.date = '1970-01-01T03:00:01')"
			. " AND (`d`.string = \"\")"
			. " AND (`d`.text = \"\")"
			. " AND (`d`.text IS NULL)) "
			. "GROUP BY `d`.date "
			. "ORDER BY `d`.date ASC";

		$this->assertEquals($expected, $this->ws($query));
	}

	function testSelect_Condition1()
	{
		$data = new Data();
		$data->setTableAlias("d");

		$dic = new Dictionary();
		$dic->setTableAlias("dic");


		$stm = new SQLStatementSelect($data);
		$stm->setLimit(10);
		$stm->setOffset(10);


		$query = $stm->generate(new SqliteGenerator());

		$expected = "SELECT"
			. " `d`.data_id AS data_id,"
			. " `d`.date AS date,"
			. " `d`.value AS value,"
			. " `d`.string AS string,"
			. " `d`.text AS text,"
//			. " `d`.enum AS enum,"
			. " `d`.blob AS blob,"
			. " `d`.real AS real,"
			. " `d`.dictionary_id AS dictionary_id"
			. " FROM `t_data` AS `d` "
			. "LIMIT 10 "
			. "OFFSET 10";

		$this->assertEquals($expected, $this->ws($query));
	}

	public function testPerformance()
	{
		$data = new Data();
		$data->setTableAlias("d");
		$stm = new SQLStatementSelect($data);
		$query = $stm->generate(new SqliteGenerator());
		//echo $query;

		//PHP   ::{$member}  -  5.29
		//PHP   ::importValueByKey() - 6.07
		//PHP   ::importValue() - 6.0


		$start = microtime(true);
		$ncount = 10;
		for($i=0; $i < $ncount; ++$i){
			$sqlArray = [10, "2020-04-14T12:00:00", 10, "some string", "some text", 0 /*enum*/, "some blob", 10.01, null];
			$objects = $stm->readSqlArray($sqlArray);
		}
		$end = microtime(true);
		//echo $end - $start;
		$this->assertEquals(true, true);

	}
}

