<?php
require_once dirname(__FILE__) . '/../ClassicLoader.php';

$loader = new \PHPClassic\ClassicLoader;
$loader::addPath(dirname(__FILE__) . '/../..');

spl_autoload_register(array($loader, 'autoLoad'));