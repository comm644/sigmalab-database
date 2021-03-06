<?php
/******************************************************************************
 Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.                         
 -----------------------------------------------------------------------------
 Module     : Abstract Data Objects : Data Provider
 File       : DataProvider.php
 Author     : Alexei V. Vasilyev
 -----------------------------------------------------------------------------
 Description:

 insert this line in your code for defining default database
 
   define( "SYSDB_DSN", "mysql://web:web@127.0.0.1/dbserfer" );

******************************************************************************/


class DataProvider
{

	function getConnection( $dsn = null)
	{
		//TODO: use config
		$ds = new DataSource();

		if ( $dsn == null ) $dsn = SYSDB_DSN;
		$ds->connect( $dsn );
		
		return(  $ds );
	}

	function getTableFor( $dsn )
	{
		$params = parse_dsn( $dsn );
		return( $params[ "table" ] );
	}

	function getEqualCondition( $name, $value )
	{
		$value = $ds->escapeString( $value );
		return( "{$name} LIKE '%{$value}%'" ); 
	}
}


