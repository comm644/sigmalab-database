<?php
require_once(__DIR__ . "/../ADO.php");
require_once(__DIR__ . "/objects/schema.php");
$rc = \Sigmalab\DatabaseEngine\PostgreFFI\PostgreDataSourceFFI::loadFFI();
if (!$rc) {
	throw new Exception("rc $rc");
}