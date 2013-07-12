<?php

namespace PHPClassic;

/**
 * @todo Windows Shell Colors
 */
class Output
{
    protected $_style;
    protected $_stream;

    private static $_foregroundStyles = array(
        'black'     => 30,
        'red'       => 31,
        'green'     => 32,
        'yellow'    => 33,
        'blue'      => 34,
        'magenta'   => 35,
        'cyan'      => 36,
        'white'     => 37
    );

    private static $_backgroundStyles = array(
        'black'     => 40,
        'red'       => 41,
        'green'     => 42,
        'yellow'    => 43,
        'blue'      => 44,
        'magenta'   => 45,
        'cyan'      => 46,
        'white'     => 47
    );

    private static $_decorationStyles = array(
        'bold'          => 1,
        'underscore'    => 4,
        'blink'         => 5,
        'reverse'       => 7,
        'conceal'       => 8
    );

    public function __construct()
    {
        $this->setOutput(fopen('php://output', 'w'));
    }

    public function setOutput($stream)
    {
        $this->_stream = $stream;
    }

    public function setColor($foreground, $background = null, $options = null)
    {
        $styles = array();
        if (isset(self::$_foregroundStyles[$foreground])) {
            $styles[] = self::$_foregroundStyles[$foreground];
        }
        if (isset(self::$_backgroundStyles[$background])) {
            $styles[] = self::$_backgroundStyles[$background];
        }
        if (isset(self::$_decorationStyles[$options])) {
            $styles[] = self::$_decorationStyles[$options];
        }
        $this->_style = implode(';', $styles);
        return $this;
    }

    public function restoreColor()
    {
        $this->_style = null;
        return $this;
    }

    public function write($line)
    {
        if ($this->_style) {
            $line = sprintf("\033[%sm%s\033[0m", $this->_style, $line);
        }
        fwrite($this->_stream, $line);
        return $this;
    }

    public function writeLn($line)
    {
        return $this->write($line . "\r\n");
    }

    public function writeTitle($title, $foreground = 'white',
        $background = 'black', $options = 'bold')
    {
        $prevStl = $this->_style;
        $this->setColor($foreground, $background, $options);

        $title = sprintf('**   %s   **', $title);
        $chars = str_repeat('*', strlen($title));

        $this->writeln($chars)->writeln($title);
        $this->writeln($chars)->writeln(null);

        $this->_style = $prevStl;
        return $this;
    }

}
