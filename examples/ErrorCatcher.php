<?php

require_once __DIR__ . '/../src/autoloader.php';

use PHPClassic\ErrorCatcher;
use PHPClassic\ErrorCatcherException;

ErrorCatcher::register();

try {
    echo $undefinedVar;
} catch(ErrorCatcherException $oExp) {
    printf("Caught %s with message: <b>%s</b><br />\n", $oExp->getName(), $oExp->getMessage());
}

try {
    trigger_error('Trigger error example', E_USER_DEPRECATED);
} catch(ErrorCatcherException $oExp) {
    printf("Caught %s with message: <b>%s</b><br />\n", $oExp->getName(), $oExp->getMessage());
}

ErrorCatcher::onFatal(function($oExp) {
    printf("Caught FATAL:%s with message: <b>%s</b><br />\n", $oExp->getName(), $oExp->getMessage());
});

//Uncomment to test fatal error catch example
//$genericClass = new \stdClass;
//$genericClass->undefinedMethod();

echo "\n<br />End execution\n";