<?php

namespace PHPClassic\Tests;

use PHPClassic\Singletoner;

class SingletonerTest extends \PHPUnit_Framework_TestCase
{
    const FIND_KEY_1 = 'walter';
    const FIND_KEY_2 = 'white';

    protected function setUp()
    {
        $ins = Singletoner::getInstance('StdClass');
        $ins->name = self::FIND_KEY_1;

        $insCusName = Singletoner::setInstance('stdClassCusName', 'StdClass');
        $insCusName->name = self::FIND_KEY_2;
    }

    public function testGetInstance()
    {
        $sameIns = Singletoner::getInstance('StdClass');
        $this->assertEquals($sameIns->name, self::FIND_KEY_1);
    }

    function testSetInstance()
    {
        $sameIns = Singletoner::getInstance('stdClassCusName');
        $this->assertEquals($sameIns->name, self::FIND_KEY_2);
    }

    public function testFlushInstance()
    {
        $ins = Singletoner::getInstance('ArrayObject');
        $ins->append('val1');
        $ins->append('val2');

        Singletoner::flushInstance('ArrayObject');
        $returnIns = Singletoner::getInstance('ArrayObject');

        $this->assertEquals($ins->count(), 2);
        $this->assertEquals($returnIns->count(), 0);
    }


    public function testUnsInstance()
    {
        $sameIns = Singletoner::getInstance('StdClass');
        Singletoner::unsInstance('StdClass');
        $returnIns = Singletoner::getInstance('StdClass');

        $this->assertNotEquals($sameIns, $returnIns);
    }
}
