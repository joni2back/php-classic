<?php

namespace PHPClassic;

/**
 * This class allows the usage of natural classes with a singleton pattern
 * Based in my own piece of code 'Multiplon / Singleton de multiples instancias'
 *
 * @link http://www.joni2back.com.ar/programacion/singleton-multiples-instancias
 * @author Jonas Sciangula Street <joni2back {at} gmail.com>
 *
 * @usage 1) Singletoner::getInstance('stdClass'); //Get by proper class name
 * @usage 2) Singletoner::getInstance('Main_Dto', 'stdClass'); //Get by ins name
 * @usage 3) Singletoner::setInstance('Main_Dto', 'stdClass'); //Set instance
 * @usage 3) Singletoner::getInstance('Main_Dto'); //Get predefined instance
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
     * @param string|object $className
     * @return object
     * @throws LogicException
     */
    public static function setInstance($instanceName, $className)
    {
        $instance = null;
        if (isset(self::$_instances[$instanceName])) {
            $instance = self::$_instances[$instanceName];
        } elseif (is_object($className) || class_exists((string) $className)) {
            $instance = self::$_instances[$instanceName] = new $className;
        } else {
            throw new LogicException("Class \"{$className}\" does not exist");
        }
        return $instance;
    }

    /**
     * Singleton method to get (or set & get) instance
     *
     * @param string $instanceName
     * @return object
     */
    public static function getInstance($instanceName, $className = null)
    {
        if ($instanceName && $className) {
            return self::setInstance($instanceName, $instanceName);
        }

        $instance = null;
        if (isset(self::$_instances[$instanceName])) {
            $instance = self::$_instances[$instanceName];
        } else {
            $instance = self::setInstance($instanceName, $instanceName);
        }
        return $instance;
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

    /**
     * Renew the instance
     *
     * @param string $instanceName
     * @return object
     */
    public static function flushInstance($instanceName)
    {
        if (isset(self::$_instances[$instanceName])) {
            $className = get_class(self::$_instances[$instanceName]);
            self::unsInstance($instanceName);
            return self::getInstance($instanceName, $className);
        }
    }

}