<?php
require_once __DIR__ . '/PHPClassic/ClassicLoader.php';

$loader = new \PHPClassic\ClassicLoader;
$loader::addPath(__DIR__);

spl_autoload_register(array($loader, 'autoLoad'));