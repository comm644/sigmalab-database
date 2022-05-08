<?php

use Database\Data;
use Sigmalab\Database\Core\DBGenCause;
use Sigmalab\Database\Core\DBValueType;
use Sigmalab\Database\Sql\SQLFunction;
use Sigmalab\Database\Sql\SQLName;
use Sigmalab\Database\Sql\SQLValue;
use Sigmalab\DatabaseEngine\Sqlite\SqliteGenerator;

require_once( __DIR__.'/env.php');
require_once( DIR_MODULES . "/ADO/ADO.php");
require_once( dirname(__FILE__ ) . "/objects/schema.php" );


class testSqlFunction extends xUnit_TestSuite
{

	public function testCount_with_alias()
	{
		$data = new Data();

		$stm = SQLFunction::count($data->tag_text(), 'count');

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Columns);
		$this->assertEquals("count( `t_data`.`text` ) AS `count`", $query);
	}

	public function testCount_direct_name_with_alias()
	{
		$name = new SQLName(null, 'column');
		$stm = SQLFunction::count($name, 'column');

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Columns);
		$this->assertEquals("count( `column` ) AS `column`", $query);
	}

	public function testCount_without_alias()
	{
		$name = new SQLName(null, 'column');
		$stm = SQLFunction::count($name);

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Columns);
		$this->assertEquals("count( `column` ) AS `column`", $query);
	}

	public function testCount_with_wildcard()
	{
		$name = new SQLName(null, '*');
		$stm = SQLFunction::count($name, 'count');

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Columns);
		$this->assertEquals("count( `*` ) AS `count`", $query);
	}

	public function testCount_noalias()
	{
		$data = new Data();

		$stm = SQLFunction::count($data->tag_text());

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Order);
		$this->assertEquals("`text`", $query); //use alias in ORDER
	}

	public function testCount_noalias_where()
	{
		$data = new Data();

		$stm = SQLFunction::count($data->tag_text());

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Where);
		$this->assertEquals("count( `t_data`.`text` ) AS `text`", $query);
	}

	public function testCount_Aliased()
	{
		$data = new Data();

		$stm = SQLFunction::count($data->tag_text(), "count");

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Columns);
		$this->assertEquals("count( `t_data`.`text` ) AS `count`", $query);
	}

	public function testDatetime()
	{
		$data = new Data();
		$stm = SQLFunction::custom("datetime",
			[$data->tag_date(), new SQLValue("unixepoch"), new SQLValue("localtime")], 'docTime',
			DBValueType::Datetime);

		$query = $stm->generate(new SqlTestGenerator(), DBGenCause::Columns);
		$this->assertEquals("datetime( `t_data`.`date` ,  \"unixepoch\" ,  \"localtime\" ) AS `docTime`", $query);
	}

	public function testDatetime_sqlite()
	{
		$data = new Data();
		$stm = SQLFunction::custom("datetime",
			[$data->tag_date(), new SQLValue('unixepoch'), new SQLValue('localtime')], 'docTime',
			DBValueType::Datetime);

		$query = $stm->generate(new SqliteGenerator(), DBGenCause::Columns);
		$this->assertEquals("datetime( `t_data`.date ,  \"unixepoch\" ,  \"localtime\" ) AS docTime", $query);
	}
}
