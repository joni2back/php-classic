<?php

require_once __DIR__ . '/../src/autoloader.php';

use PHPClassic\ExceptionCatcher;

ExceptionCatcher::register();

function getDataFromDatabase()
{
    try {
        throw new \ErrorException('Will be caught');
    } catch (\Exception $oExp) {
        throw new \LogicException('Exception not caught', null, $oExp);
    }
}

function prepareData()
{
    return getDataFromDatabase();
}

function collectData()
{
    return prepareData();
}

function generate()
{
    return collectData();
}

function display()
{
    return generate();
}

display();