<?php

namespace PHPClassic\Tests;

use PHPClassic\Singletoner;

class SingletonerTest extends \PHPUnit_Framework_TestCase
{
    const FIND_KEY_1 = 'walter';
    const FIND_KEY_2 = 'white';

    function testSetInstance()
    {
        $instance = new \stdClass();
        $instance->name = self::FIND_KEY_1;
        $singletoned = Singletoner::setInstance('stdClassCusName', $instance);

        $this->assertEquals($singletoned->name, self::FIND_KEY_1);

        try {
            Singletoner::setInstance('unknownSingleton', 'Unknown');
            $this->fail("Expected exception not thrown");
        } catch (\Exception $oExp) {
            $this->assertEquals("Class \"Unknown\" does not exist", $oExp->getMessage());
        }
    }

    public function testGetInstance()
    {
        $instance = new \stdClass();
        $instance->name = self::FIND_KEY_2;
        Singletoner::setInstance('stdClassCusName2', $instance);
        $singletoned = Singletoner::getInstance('stdClassCusName2');
        $this->assertEquals($singletoned->name, self::FIND_KEY_2);

        try {
            Singletoner::getInstance('UnknownInstance');
            $this->fail("Expected exception not thrown");
        } catch (\Exception $oExp) {
            $this->assertEquals("Instance \"UnknownInstance\" does not exist", $oExp->getMessage());
        }
    }

    public function testUnsInstance()
    {
        try {
            Singletoner::setInstance('stdClassCusName3', new \stdClass());
            Singletoner::unsInstance('stdClassCusName3');
            Singletoner::getInstance('stdClassCusName3');
            $this->fail("Expected exception not thrown");
        } catch (\Exception $oExp) {
            $this->assertEquals("Instance \"stdClassCusName3\" does not exist", $oExp->getMessage());
        }
    }
}
