<?php

namespace PHPClassic;

/**
 * This class allows the usage of natural classes with a singleton pattern
 * Based in my own piece of code 'Multiplon / Singleton de multiples instancias'
 *
 * @link http://www.joni2back.com.ar/programacion/singleton-multiples-instancias
 * @author Jonas Sciangula Street <joni2back {at} gmail.com>
 *
 * @usage
 *    Singletoner::setInstance('Main_Dto', new \stdClass);
 *    Singletoner::getInstance('Main_Dto');
 */
abstract class Singletoner
{

    /**
     * The magic are there
     *
     * @var array $_instances
     */
    private static $_instances = array();

    /**
     * Setup the instance with own name
     *
     * @param string $instanceName
     * @param string|object $class
     * @param bool $rewrite
     * @return object
     * @throws LogicException
     * @throws ErrorException
     */
    public static function setInstance($instanceName, $class, $rewrite = false)
    {
        if (isset(self::$_instances[$instanceName]) && !$rewrite) {
            throw new \ErrorException("Instance \"{$instanceName}\" already defined");
        } elseif (is_object($class)) {
            return self::$_instances[$instanceName] = $class;
        } elseif (is_string($class) && class_exists($class)) {
            return self::$_instances[$instanceName] = new $class;
        } 
        throw new \LogicException("Class \"{$class}\" does not exist");
    }

    /**
     * Singleton method to get (or set & get) instance
     *
     * @param string $instanceName
     * @return object
     */
    public static function getInstance($instanceName)
    {
        if (isset(self::$_instances[$instanceName])) {
            return self::$_instances[$instanceName];
        }
        throw new \LogicException("Instance \"{$instanceName}\" does not exist");
    }

    /**
     * Remove instance from container
     *
     * @param string $instanceName
     */
    public static function unsInstance($instanceName)
    {
        if (isset(self::$_instances[$instanceName])) {
            unset(self::$_instances[$instanceName]);
        }
    }

}
