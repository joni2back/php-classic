<?php

namespace PHPClassic\Tests;

use PHPClassic\ClassicLoader;

class ClassicLoaderTest extends \PHPUnit_Framework_TestCase
{
    const FIND_KEY = 'heisenberg';

    public function testAddPath()
    {
        $path = dirname(dirname(__DIR__));
        ClassicLoader::addPath($path);
        $this->assertTrue(in_array($path, ClassicLoader::getPaths()));
    }

    public function testGetPaths()
    {
        $this->assertTrue(is_array(ClassicLoader::getPaths()));
    }

    public function testAddExt()
    {
        ClassicLoader::addExt(self::FIND_KEY);
        $this->assertTrue(in_array(self::FIND_KEY, ClassicLoader::getExts()));
    }

    public function testGetExts()
    {
        $this->assertTrue(is_array(ClassicLoader::getExts()));
    }
}
