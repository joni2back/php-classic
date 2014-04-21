<?php

require_once __DIR__ . '/../src/autoloader.php';

use PHPClassic\Singletoner;

$class1 = new stdClass();
$class1->name = 'stdClass1';

$class2 = new stdClass();
$class2->name = 'stdClass2';

Singletoner::setInstance('standard_class_1', $class1);
Singletoner::setInstance('standard_class_2', $class2);

header('Content-Type: text');

var_export(array(
    '$class1 === Singletoner::getInstance("standard_class_1")' => $class1 === Singletoner::getInstance("standard_class_1"),
    '$class2 === Singletoner::getInstance("standard_class_2")' => $class2 === Singletoner::getInstance("standard_class_2"),
    '$class1 === Singletoner::getInstance("standard_class_2")' => $class1 === Singletoner::getInstance("standard_class_2"),
    '$class2 === Singletoner::getInstance("standard_class_1")' => $class2 === Singletoner::getInstance("standard_class_1")
));

unset($class1, $class2);
echo "\n\n";

$class1 = Singletoner::getInstance("standard_class_1");
$class2 = Singletoner::getInstance("standard_class_2");

var_export(array(
    '$class1->name === "stdClass1"' => $class1->name === "stdClass1",
    '$class2->name === "stdClass2"' => $class2->name === "stdClass2",
    '$class1->name === "stdClass2"' => $class1->name === "stdClass2",
    '$class2->name === "stdClass1"' => $class2->name === "stdClass1"
));