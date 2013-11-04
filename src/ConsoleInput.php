<?php

namespace PHPClassic;
use PHPClassic\ConsoleOutput;

class ConsoleInput
{
    protected $_required = true;
    protected $_validation = '';
    protected $_validationMsg = '';
    protected $_stream;

    /**
     * @param PHPClassic\ConsoleOutput $outputIns
     */
    public function __construct(ConsoleOutput $outputIns)
    {
        $this->setInput(fopen('php://stdin', 'r'));
        $this->output = $outputIns;
    }

    /**
     * @param string $message
     * @param string $default
     * @return string
     */
    public function prompt($message, $default = null)
    {
        $input = null;
        $msg = $default ?
            sprintf('%s (default: \'%s\'): ', $message, $default) :
            sprintf('%s: ', $message);

        while (true) {
            $this->writePrompt($msg);
            fscanf($this->_stream, "%s", $input);
            if ($input && $this->_validation &&
                ! preg_match($this->_validation, $input)) {
                $this->writeAlert($this->_validationMsg);
                $input = null;
                continue;
            }
            if (! $input && $this->_required) {
                continue;
            }
            if (! $input) {
                $input = $default;
            }
            break;
        }

        $this->flush();
        return $input;
    }

    /**
     * @param resource $stream
     */
    public function setInput($stream)
    {
        $this->_stream = $stream;
        return $this;
    }

    /**
     * @return PHPClassic\ConsoleInput
     */
    protected function flush()
    {
        $this->_required = true;
        $this->_validation = '';
        $this->_validationMsg = '';
        return $this;
    }

    /**
     * @param bool $required
     * @return PHPClassic\ConsoleInput
     */
    public function required($required = true)
    {
        $this->_required = $required;
        return $this;
    }

    /**
     * @param string $pattern
     * @param string $onErrorMessage
     * @return PHPClassic\ConsoleInput
     */
    public function validate($pattern, $onErrorMessage = '')
    {
        $this->_validation = $pattern;
        $this->_validationMsg = $onErrorMessage;
        return $this;
    }

    /**
     * @return PHPClassic\ConsoleOutput
     */
    protected function getOutput()
    {
        return $this->output;
    }

    /**
     * @param string $message
     * @param string $color
     * @return PHPClassic\ConsoleInput
     */
    protected function writePrompt($message, $color = 'yellow')
    {
        $this->getOutput()->setColor($color)->write($message)->restoreColor();
        return $this;
    }

    /**
     * @param string $message
     * @param string $color
     * @return PHPClassic\ConsoleInput
     */
    protected function writeAlert($message, $color = 'red')
    {
        $this->getOutput()->setColor($color)
            ->write(sprintf("    %s\n", $message))
            ->restoreColor();
        return $this;
    }

}