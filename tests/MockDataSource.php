<?php /** @noinspection PhpMultipleClassesDeclarationsInOneFile */

use Sigmalab\Database\Core\DataSourceLogger;
use Sigmalab\Database\Core\DBDataSource;
use Sigmalab\Database\Core\DBResultContainer;

require_once( DIR_MODULES . "/funcset/copy_members.php" );
require_once( DIR_MODULES . "/debug/debug.php" );


class MockQueryAnswer
{
	public $rc;
	public int $lastInsertID;

	public function __construct($rc, $lastInsertID = 1)
	{
		$this->rc = $rc;
		$this->lastInsertID = $lastInsertID;
	}
}


class MockDataSource extends DBDataSource
{
	public bool $signShow;
	/**
	 * @var int
	 */
	private int $nRequest;
	/**
	 * @var array
	 */
	public array $answer;


	public function __construct()
	{
		$this->answer = array();
		$this->query = array();
		$this->signShow = false;
		$this->lastInsertID = 1;
		$this->nRequest = 0;
		$this->request = array();
	}

	public function getGenerator()
	{
		return new SqlTestGenerator();
	}

	public function getLogger()
	{
		return DataSourceLogger::getInstance();
	}

	public function isLinkAvailable()
	{
		return true;
	}

	public function register()
	{
		$this->nRequest++;
		$trace = debug_backtrace();
		$info = $trace[1];
		if ($this->signShow) {
			$msg = sprintf("call: %s::%s \nargs: %s",
				$info["class"], $info["function"], dumpvar($info["args"]));
			printd($msg);
		}
		array_push($this->request, $trace[1]);
	}

	public function querySelect($query, $resultContainer, $class = null, $signUseID = true): int
	{
		if ($this->signShow) print_r($query);
		$this->query[] = $query;

		$answer = array_shift($this->answer);
		TS_ASSERT(is_array($answer), "Answer item should be array in [{$this->nRequest}] for $query");
		$row = 0;
		foreach ($answer as $id => $item) {
			if (!is_object($class)) {
				Diagnostics::error("invalid argument 'class'");
			}
			$obj = clone $class;
			if (strtolower(get_class($obj)) != "stdclass") {
				TS_ASSERT(is_array($item), "Answer item should be array in [{$this->nRequest}:$row] for $query");
				if (count(get_object_vars($obj)) != count($item)) {
					TS_ASSERT_EQUALS(count(get_object_vars($obj)), count($item), "The answer does not have members for object fill in [query=#{$this->nRequest} row=#$row query='$query'], count of members:");
					Diagnostics::printd("expected object:");
					Diagnostics::printd($obj);
					Diagnostics::printd("programmed answer:");
					Diagnostics::printd($item);
				}
				copy_from_array($obj, $item);
			} else {
				$obj = array_to_object($item);
			}
			$resultContainer[$id] = $obj;
			$row++;
		}
		$this->register();
		return (0);
	}

	/**
	 * query select
	 *
	 * @param string $query
	 * @param DBResultContainer $resultContainer
	 * @return int
	 */
	public function querySelectEx(string $query, DBResultContainer $resultContainer): int
	{
		if ($this->signShow) print_r($query);
		$this->query[] = $query;

		$answer = array_shift($this->answer);
		TS_ASSERT(is_array($answer), "Answer item should be array in [{$this->nRequest}] for $query");
		$row = 0;

		foreach ($answer as $row) {

			$obj = $resultContainer->fromSQL($row);
			$resultContainer->add($obj);
			$row++;
		}
		return 0;
	}


	public function queryCommand(string $query, DBResultContainer $resultContainer)
	{
		$rc = true;
		if ($this->signShow) printd($query);
		$this->query[] = $query;


		if (!is_array($this->answer)) {
			TS_ASSERT(false, " in [{$this->nRequest}: ]");
			TS_TRACE("Answers for MockDataSource is not defined. should be Array");
		}

		$answer = array_shift($this->answer);
		if (!is_object($answer)) {
			TS_ASSERT(false, "Answers for MockDataSource is not defined.");
			TS_TRACE("Answers for MockDataSource is not defined.");
		} else {
			$this->lastInsertID = $answer->lastInsertID;
			$rc = $answer->rc;
		}
		$this->register();
		return ($rc);
	}

	public function lastID(): int
	{
		return ($this->lastInsertID);
	}

	public function escapeString($str)
	{
		return $str;
	}

	public function templateQuery($filename, $vars, &$result, $signUseID = false, $class = null)
	{
		$rc = 0;
		$this->register();
		if (!is_array($this->answer) || count($this->answer) == 0) {
			TS_ASSERT(false, " in [{$this->nRequest}] for $filename");
			printd($vars);
			TS_TRACE("Answers for MockDataSource is not defined. should be Array");
		}

		$result = array_shift($this->answer);
		return 0;
	}

	public function getDateTime($val)
	{
		return (strftime("%Y-%m-%d %H:%M:%S", $val));
	}


	public function addTemplateValues($values, $rc = 0)
	{
		$this->answer[] = array(array("values" => $values, "rc" => $rc));
	}

	/**
	 * Retrieve eroror message or code from DB engine (mysql/...)
	 * @return string error message
	 * @access protected
	 */
	public function getEngineError()
	{
		// TODO: Implement getEngineError() method.
	}

	/**
	 * Gets DB engine name.
	 * @return string engine name (mysql, or sqlite..)
	 * @access protected
	 */
	public function getEngineName()
	{
		// TODO: Implement getEngineName() method.
	}

	/** method performs connecting to data base
	 * @param string $dsn \b string describes Data Source Name  as next string:
	 *
	 * engine_name://username:password@server[:port]/database
	 * @return void code as \b enum specified for concrete data source
	 */
	public function connect(string $dsn)
	{
		// TODO: Implement connect() method.
	}


}

?>