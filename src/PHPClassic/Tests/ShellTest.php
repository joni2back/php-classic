<?php

namespace PHPClassic\Tests;

use PHPClassic\Shell;

class ShellTest extends \PHPUnit_Framework_TestCase
{
    const FIND_KEY = 'heisenberg';
    public $shell;

    protected function setUp()
    {
        $this->shell = new Shell;
        $this->shell->execute('echo', array(self::FIND_KEY));
    }

    protected function assertNumeric($input)
    {
        return $this->assertTrue(is_numeric($input));
    }

    protected function assertBoolean($input)
    {
        return $this->assertTrue(is_bool($input));
    }

    public function testExecute()
    {
        $execution = $this->shell->execute('echo', array(self::FIND_KEY));
        $this->assertEquals($this->shell, $execution);
    }

    public function testGetStatus()
    {
        $this->assertEquals($this->shell->getStatus(), 0);
        $this->assertNumeric($this->shell->getStatus());
    }

    public function testGetOutput()
    {
        $this->assertStringMatchesFormat($this->shell->getOutput(), self::FIND_KEY);
        $this->assertEquals($this->shell->getOutput(), self::FIND_KEY);
    }

    public function testGetTotalLines()
    {
        $this->assertEquals($this->shell->getTotalLines(), 1);
        $this->assertNumeric($this->shell->getTotalLines());
    }

    public function testIsSuccessful()
    {
        $this->assertTrue($this->shell->isSuccessful());
        $this->assertBoolean($this->shell->isSuccessful());
    }

    public function testGrep()
    {
        $grepped = $this->shell->grep('/^'.self::FIND_KEY.'$/');
        $this->assertEquals($grepped->getOutput(), self::FIND_KEY);
    }

}
