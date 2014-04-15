<?php

require_once __DIR__ . '/../src/autoloader.php';

use PHPClassic\Catcher;
use PHPClassic\CatcherException;

Catcher::register();

try {
    echo $undefinedVar;
} catch(CatcherException $oExp) {
    printf("Caught %s with message: <b>%s</b><br />\n", $oExp->getName(), $oExp->getMessage());
}

try {
    trigger_error('Trigger error example', E_USER_DEPRECATED);
} catch(CatcherException $oExp) {
    printf("Caught %s with message: <b>%s</b><br />\n", $oExp->getName(), $oExp->getMessage());
}

Catcher::onFatal(function($oExp) {
    printf("Caught FATAL:%s with message: <b>%s</b><br />\n", $oExp->getName(), $oExp->getMessage());
});

//Uncomment to test fatal error catch example
//$genericClass = new \stdClass;
//$genericClass->undefinedMethod();

echo "\n<br />End execution\n";