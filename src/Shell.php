<?php

namespace PHPClassic;

/**
 * Shell exec helper
 *
 * @author  Jonas Sciangula <joni2back@gmail.com>
 */
class Shell
{
    protected $_status = null;
    protected $_output = array();

    /**
     * @param string $command
     * @param array $params
     */
    public function __construct($command = '', array $params = array())
    {
        if ($command) {
            $this->execute($command, $params);
        }
    }

    /**
     * @param string $command
     * @param array $params
     * @return PHPClassic\ClassicShell
     */
    public function execute($command, array $params = array())
    {
        $params = array_map(function($str) {
            return escapeshellarg($str);
        }, $params);

        $command = trim(sprintf('%s %s', $command, implode(' ', $params)));
        exec($command, $this->_output, $this->_status);

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @param  bool $asArray
     * @return mixed
     */
    public function getOutput($asArray = false)
    {
        return $asArray ? $this->_output : implode("\n", $this->_output);
    }

    /**
     * @return int
     */
    public function getTotalLines()
    {
        return count($this->getOutput());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return __CLASS__;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return 0 === $this->getStatus();
    }

    /**
     * @param  string $pattern
     * @param  bool $ignore
     * @return PHPClassic\ClassicShell
     */
    public function grep($pattern, $ignore = false)
    {
        $result = preg_grep($pattern, $this->_output);
        $this->_output = $ignore ?
            array_values(array_diff($this->_output, $result)) : $result;
        return $this;
    }

}
