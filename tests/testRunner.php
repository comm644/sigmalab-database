<?php
/******************************************************************************
 Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.                         
 -----------------------------------------------------------------------------
 Module     : phpTest runner
 File       : phptestrunner.php
 Author     : Alexei V. Vasilyev
 -----------------------------------------------------------------------------
 Description:
******************************************************************************/
require_once( __DIR__ . "/../../phptest/phptest.php" );

date_default_timezone_set("Europe/Moscow");

define( "DIR_MODULES", __DIR__ . "/../../" );
define( "DIR_LOG", __DIR__ . "/" );
require_once( DIR_MODULES . "/debug/debug.php");
require_once( __DIR__ . '/../ADO.php');

require_once __DIR__.'/SqlTestGenerator.php';
require_once __DIR__.'/env.php';

// test suites define

// end test suites define


$argc = $_SERVER['argc'];
$argv = $_SERVER['argv'];
if ( $argc > 1 ) {
	for( $i=1;  $i <$argc; $i++ ) {
		print( "Loading {$argv[$i]}...\n" );
		require_once( $argv[$i] );
	}
	phpTest::run();
}
else {
	phpTest::run(true);
}


