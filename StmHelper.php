<?php

use Sigmalab\Database\Core\DBObject;
use Sigmalab\Database\Expressions\ExprEQ;
use Sigmalab\Database\Sql\SQLFunction;
use Sigmalab\Database\Sql\SQLStatementDelete;
use Sigmalab\Database\Sql\SQLStatementInsert;
use Sigmalab\Database\Sql\SQLStatementSelect;
use Sigmalab\Database\Sql\SQLStatementUpdate;

/**
 * Class which incapsulates common statements and must be used as
 * base class for project DbHelper.
 * This cmass must be moved to ADO subsystem.
 */
class StmHelper
{
    /**
     * Gets SQL statement for selecting item by primary key.
     *
     * @param DBObject  $proto
     * @param integer $id
     * @return SQLStatementSelect
     */
    public static function stmSelectByPrimaryKey($proto, $id )
    {
        $stm = new SQLStatementSelect( $proto );
        $stm->addExpression( new ExprEQ($proto->getPrimaryKeyTag(), $id ));
        return $stm;
    }

    /**
     * Gets SQL statement for selecting item by primary key.
     *
     * @param DBObject  $proto
     * @param integer $id
     * @return SQLStatementDelete
     */
    public static function stmDeleteByPrimaryKey($proto, $id )
    {
        $stm = new SQLStatementDelete( $proto );
        $stm->setExpression( new ExprEQ($proto->getPrimaryKeyTag(), $id ));
        return $stm;
    }

	/**
	 * Gets statamenrt for updating or inserting object to database.
	 *
	 * @param DBObject $object  object instance for storing.
	 * @return SQLStatementInsert|SQLStatementUpdate|null
	 */
	public static function stmSmartUpdate( $object )
	{
		if ( $object->isNew() ) {
			$stm = new SQLStatementInsert( $object );
		}
		else {
			if ( !$object->isChanged()) return null;
			$stm = new SQLStatementUpdate($object );
		}
		return $stm;
	}

	/**
	 * Add count field to statement.
	 *
	 * @param SQLStatementSelect $stm
	 * @return SQLStatementSelect
	 */
	static function stmAddCount(SQLStatementSelect $stm)
	{
		$stm->addColumn( SQLFunction::count( $stm->object->getPrimaryKeyTag(), "count" ) );
		return $stm;
	}

}
