<?php
class slock
{
    static function  signal($name)
    {
	TS_TRACE( "signaled $name\n" );
	touch( $name );
    }
    static function wait($name )
    {
	while( !file_exists( $name ) ) {
	    TS_TRACE( "wait signal $name\n" );
	    sleep( 1 );
	}
	unlink( $name );
    }
}