<?php

use Sigmalab\Database\Core\DBDataSource;
use Sigmalab\Database\Core\DBObject;
use Sigmalab\Database\Sql\SQLStatement;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;


/**
Database helper.
*/
class DbHelper extends StmHelper
{
	/** Create new connection
	 *   @return DBDataSource connected DataSource object
	*/
	public static function getConnection()
	{
		return DbHelper::connect(SAMLE_DSN);
	}

	/** Get connected "DataSource" object for the specific DSN
	    @return IDataSource connected DataSource object if all right, NULL otherwise
	*/
	public function connect($dsn)
	{
		$ds = new Mysql51DataSource();
		$ds->signSuppressError = SUPPRESS_ERROR_PERSISTENT;
		$ds->signShowQueries = false;
		$ds->signDebugQueries = false;
		if(DS_SUCCESS == $ds->connect($dsn)){
			return $ds;
		}
		// TODO: error handling ........
		return null;
	}

	/**
	 * execute statement
	 * @param SQLStatement $stm
	 * @param bool $registerChanges   true if need register changes.
	 * @return array
	 */
	static function execute( SQLStatement $stm, $registerChanges=true )
	{
		if ( !$stm ) {
			return array();
		}
		$db = self::getConnection();
		$db->signDebugQueries = true;

		$res = $stm->createResultContainer(true);
		$db->queryStatement($stm, $res);

		$lastID = -1;
		if (  $stm instanceof SQLStatementInsert) {
			$lastID = $db->lastID();
			$stm->object->set_primary_key_value( $lastID );
		}
		if ( $registerChanges ) {
			self::registerChanges($stm);
		}
		if ( $lastID != -1 ) {
			return $lastID;
		}
		return $res->getResult();
	}

	/**
	 * Register any request.
	 *
	 * @param SQLStatementSelect $stm  executed statement
	 */
	private static function registerChanges( $stm )
	{
		if ( $stm instanceof SQLStatementSelect) {
			return;
		}
		//WebApplication::registerChanges();
	}

	/**
	 * Select one item from reqult
	 *
	 * @param SQLStatementSelect $stm
	 * @return DBObject
	 */
	static function executeSelectOne( $stm )
	{
		$objs = self::execute($stm);
		return array_shift( $objs );
	}

	public static function executeTransaction($stms)
	{
		$conn = self::getConnection();

		$conn->queryCommand("START TRANSACTION;");
		foreach( $stms as $stm ) {
			self::execute($stm);
		}
		$conn->queryCommand("COMMIT;");
	}

	public static function openTranscaction()
	{
		$conn = self::getConnection();
		$conn->queryCommand("START TRANSACTION;");
	}

	public static function commitTransaction()
	{
		$conn = self::getConnection();
		$conn->queryCommand("COMMIT;");
	}
}
