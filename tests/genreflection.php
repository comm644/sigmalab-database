<?php

#ifndef KPHP
require_once __DIR__.'/../autoload.php';
require_once __DIR__.'/objects/schema.php';

function gen($className)
{
	$app = new \Sigmalab\SimpleReflection\ReflectionGenerator();

	$filename = str_replace("\\", "/", __DIR__ . "/$className.php");
	$dirname= dirname($filename);
	if  (!file_exists($dirname)) {
		mkdir($dirname, 0700, true);
}
	file_put_contents($filename, $app->generate($className));
	echo "Generated $filename\n";
}

gen(\Database\Data::class);



#endif

