<?php

namespace Sigmalab\Database\Relations;

define("DBH_ADD", 0);
define("DBH_REMOVE", 1);
define("DBH_ADDLINK", 2);
define("DBH_REMOVELINK", 3);
define("DBH_UPDATE", 4);

class DBHistory
{
	public int $op;
	public string $container = '';
	public int  $index;
	public ?object $deletedObject = null;

	public function __construct(int $op, string $container, int $index, ?object $deletedObject = null)
	{
		$this->op = $op;
		$this->container = $container;
		$this->index = $index;
		$this->deletedObject = $deletedObject;
	}
}

