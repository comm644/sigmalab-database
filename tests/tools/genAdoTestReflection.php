<?php

#ifndef KPHP
use Compiler\AppReflectionGenerator;
use Maintenance\AdoTestsReflectionGenerator;
use Sigmalab\SimpleReflection\ReflectionHelper as refhelper;

require_once __DIR__ . '/../../ADO.php';
require_once __DIR__ . '/AdoTestsReflectionGenerator.php';


spl_autoload_register( function($class) {

	$class = str_replace('\\', '/', $class);
	foreach( array(
		         __DIR__.'/../objects',
		) as $path ) {
		$name = $path . '/'.$class . '.php';

		if ( file_exists( $name ) ) {
			require_once( $name);
			return;
		}
		$name = $path . '/'.$class . '/'.$class . '.php';
		if ( file_exists( $name ) ) {
			require_once( $name);
			return;
		}
		$className = basename($class);
		$namespaceName = dirname($class);
		$name = $path . '/'.$namespaceName . '/Types/'.$className . '.php';

		if ( file_exists( $name ) ) {
			require_once( $name);
			return;
		}
	}
});



$it = new RecursiveDirectoryIterator(__DIR__.'/../objects');
$display = Array('php');
foreach (new RecursiveIteratorIterator($it) as $file) {
	if  (basename($file ) == basename(__FILE__) ) continue;
	$parts = explode('.', $file);
	if (in_array(strtolower(array_pop($parts)), $display)) {

		$matches = [];
		$content = file_get_contents($file);

		if ( preg_match("/class (.*)implements IReflectedObject/", $content, $matches)) {

			$className = explode(" ", $matches[1])[0];
			if ( preg_match("/namespace (.*);/", $content, $nsmatches)) {
				$ns = $nsmatches[1];
			}
			$fullNme = $ns.'\\'.$className;
			refhelper::register( $fullNme);
			echo "Found class \\$fullNme \n";
		}
		if ( preg_match("/class (.*)extends .*DBObject/", $content, $matches)) {

			$className = explode(" ", $matches[1])[0];
			if ( preg_match("/namespace (.*);/", $content, $nsmatches)) {
				$ns = $nsmatches[1];
			}
			$fullNme = $ns.'\\'.$className;
			refhelper::register( $fullNme);
			echo "Found class \\$fullNme \n";
		}
	}
}


$out = "";
foreach (AdoTestsReflectionGenerator::getClasses() as $instance) {
	if (!$instance) continue;
	$out .= Maintenance\AdoTestsReflectionGenerator::generateReflection($instance);
}

$out = str_replace("\n", "\n\t\t", $out);
$registry = <<<TEXT
<?php
namespace Reflection;
use Sigmalab\SimpleReflection\ClassRegistry;

class AppReflectionRegistry
{
	public static function init()
	{
		ClassRegistry::init();
		$out
	}
}

TEXT;

AdoTestsReflectionGenerator::saveFile('AppReflectionRegistry', $registry);

#endif