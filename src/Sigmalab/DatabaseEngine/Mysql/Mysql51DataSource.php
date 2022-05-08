<?php

namespace Sigmalab\DatabaseEngine\Mysql;

class Mysql51DataSource extends MysqlDataSource
{
	public function setEncoding()
	{
		if (function_exists("mysql_set_charset")) {
			$rc = mysql_set_charset("utf8", $this->link);
			if ($rc === false) {
				$this->registerError('mysql_set_charset()');
			}
		} else {
			parent::setEncoding();
		}
	}

	/**
	 * Set packet size for accepting big blobs
	 *
	 * @return int
	 */
	public function setPacketSize()
	{
		//$rc = $this->queryCommand("SET GLOBAL max_allowed_packet=50000000");
		return DS_SUCCESS;
	}

}