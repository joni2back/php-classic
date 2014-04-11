<?php
require_once __DIR__ . '/../ClassicLoader.php';

$loader = new \PHPClassic\ClassicLoader;
$loader::addPath(__DIR__ . '/../..');

spl_autoload_register(array($loader, 'autoLoad'));