<?php

namespace PHPClassic;

class CatcherException extends \ErrorException
{
    /**
     * @var string
     */
    public $name;

    /**
     * @param string $message
     * @param int $code
     * @param int $severity
     * @param string $filename
     * @param int $lineno
     * @param \Exception $previous
     */
    public function __construct($message, $code, $severity, $filename, $lineno, $previous = null)
    {
        parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
        $this->name = static::getNameByCode($code);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $errno
     * @return string
     */
    public static function getNameByCode($errno)
    {
        $name = null;
        switch ($errno) {
            case \E_ERROR:
                $name = 'E_ERROR';
                break;
            case \E_RECOVERABLE_ERROR:
                $name = 'E_RECOVERABLE_ERROR';
                break;
            case \E_WARNING:
                $name = 'E_WARNING';
                break;
            case \E_PARSE:
                $name = 'E_PARSE';
                break;
            case \E_NOTICE:
                $name = 'E_NOTICE';
                break;
            case \E_STRICT:
                $name = 'E_STRICT';
                break;
            case \E_DEPRECATED:
                $name = 'E_DEPRECATED';
                break;
            case \E_CORE_ERROR:
                $name = 'E_CORE_ERROR';
                break;
            case \E_CORE_WARNING:
                $name = 'E_CORE_WARNING';
                break;
            case \E_COMPILE_ERROR:
                $name = 'E_COMPILE_ERROR';
                break;
            case \E_COMPILE_WARNING:
                $name = 'E_COMPILE_WARNING';
                break;
            case \E_USER_WARNING:
                $name = 'E_USER_WARNING';
                break;
            case \E_USER_NOTICE:
                $name = 'E_USER_NOTICE';
                break;
            case \E_USER_DEPRECATED:
                $name = 'E_USER_DEPRECATED';
                break;
            case \E_USER_ERROR:
                $name = 'E_USER_ERROR';
                break;
        }
        return $name;
    }
}