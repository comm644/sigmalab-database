<?php

namespace Maintenance;

use Exception;
use Sigmalab\SimpleReflection\ReflectionHelper;

class AdoTestsReflectionGenerator
{

	/**
	 * @param $instance
	 * @return string
	 * @throws Exception
	 */
	public static function generateReflection($instance): string
	{
		$className = get_class($instance);
		$app = new \Sigmalab\SimpleReflection\ReflectionGenerator();
		try {
			$result = $app->generate($className);
			$prefix = "";
		}catch (\Throwable $e) {
			echo "\n\n\e[31mError on process $className: {$e->getMessage()}\e[0m\n\n";
			$result = "//error caused.";
			$prefix = "//FIXME: error on processing ";
		}

		self::saveFile($className."_reflection", $result);

		return "$prefix\\{$className}_reflection::registerClass();\n";
	}

	/**
	 * @return object[]
	 */
	public static function getClasses(): array
	{
		return array_map(function ($name) {
			return new $name;
		}, ReflectionHelper::getNames());
	}

	/**
	 * @param string $className
	 * @param string $result
	 */
	public static function saveFile(string $className, string $result): void
	{
		$outfile = str_replace("\\", "/",  __DIR__. "/../objects/Reflection/$className.php");
		$dir = dirname($outfile);
		if (!file_exists($dir)) {
			/** @noinspection MkdirRaceConditionInspection */
			mkdir($dir, 0777, true);
		}
		file_put_contents($outfile, $result);
		echo "Reflection saved for  \\$className\n";
	}
}