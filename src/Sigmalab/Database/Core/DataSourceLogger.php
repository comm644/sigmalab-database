<?php

namespace Sigmalab\Database\Core;
class DataSourceLogger
{
	protected static ?self $instance = null;

	/** get object instance
	 *
	 * @return self inherited class instances
	 */
	public static function getInstance():self
	{
		if  (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/** set object instance.
	 * @param self $obj what an object need set
	 */
	public static function setInstance(self $obj): void
	{
		self::$instance = $obj;
	}

	public function __construct()
	{
		self::setInstance($this);
	}

	public function debug(string $msg): void
	{

	}

	public function notice(string $msg): void
	{

	}

	public function warning(string $msg): void
	{

	}

	public function error(string $msg): void
	{

	}
}
