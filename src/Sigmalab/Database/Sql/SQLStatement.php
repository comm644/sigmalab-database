<?php

namespace Sigmalab\Database\Sql;

use CompileTimeLocation;
use Sigmalab\Database\Core\DBQuery;
use Sigmalab\Database\Core\IDataObject;
use Sigmalab\Database\Core\IDBColumnDefinition;
use Sigmalab\Database\Expressions\IExpression;


abstract class SQLStatement
{
	public string $sqlStatement = "--- undefined --";
	public string $sqlWhere = "WHERE";
	public string $sqlLimit = "LIMIT";

	/**  Object with metainformation for creating default statement. */
	public IDataObject $object;

	/**
	 * Columns for selection
	 * @var IDBColumnDefinition[]
	 */
	public array $columnDefs = [];
	public ?string $table = null;

	public ?string $isDebug = null;
	public string $cacheKey = "";
	public string $lastPair = "";

	public function __construct(IDataObject $obj)
	{
		$this->object = $obj;
		$this->columnDefs = array();
		foreach ($this->object->getColumnDefinition() as $def) {
			$this->columnDefs[(string)$def->getAliasOrName()] = $def;
		};
		$this->table = $this->object->table_name();

	}

	/**
	 * @return string[]
	 */
	protected function primaryKeys(): array
	{
		/** @var string[] $pk */
		$pk = [(string)$this->object->getPrimaryKeyTag()->getName()];
		return ($pk);
	}

	public function setDebug(?string $debugSource=null):self
	{
		$this->isDebug = $debugSource;
		return $this;
	}

	public function cacheIt_kphp(CompileTimeLocation $caller, ?CompileTimeLocation $loc=null)
	{
		if (!$loc) {
			$loc = CompileTimeLocation::calculate($loc);
		}
		$pair = $caller->file . ':' . $caller->line . ' -> ' . $loc->file . ':' . $loc->line;
		if ($this->lastPair === $pair) return;
		$this->cacheKey .= $pair;
		$this->lastPair = $pair;
	}

	public function cacheIt()
	{
#ifndef KPHP
		$bt = @debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
		if ( 0 ) {
			$pair = $bt[1]["file"] . ':' . $bt[1]["line"] . " -> "
				 . @$bt[2]["file"] . ':' . @$bt[2]["line"] . "\n";
			if  ($this->lastPair === $pair) return;
			$this->cacheKey .= $pair;
			$this->lastPair = $pair;
		}
		else {
			$pair = basename($bt[1]["file"]) . ':' . $bt[1]["line"]
				. " -> " .basename(@$bt[2]["file"]) . ':' . @$bt[2]["line"] . " - ".$bt[1]['function']."\n";

			if  ($this->lastPair === $pair) return;
			$this->cacheKey .= $pair;
			$this->lastPair = $pair;
		}
#endif
		//echo "cachekey: ".$this->cacheKey ."\n";
	}

	abstract public function generateQuery(SQLGenerator $generator): DBQuery;

	/**
	 * @param int $mode
	 * @return string
	 * @throws \Exception
	 */
	abstract public function generate(SQLGenerator $generator, int $mode = 0): string;

	abstract public function addExpression(IExpression $expr) :self;
}



