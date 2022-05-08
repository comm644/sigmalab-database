<?php /** @noinspection PhpMultipleClassesDeclarationsInOneFile */

use ObjectDocuments\DocumentStorage;
use Time\TimeProvider;
use ExtensionApi\Signals;
use VirtualHost\VirtualHost;

ini_set("display_errors", true);
ini_set("error_reporting", E_ALL);

require_once __DIR__.'/SqlTestGenerator.php';

require_once __DIR__.'/../../phptest/xunit.php';
