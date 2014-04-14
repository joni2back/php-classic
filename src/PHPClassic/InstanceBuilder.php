<?php

namespace PHPClassic;

/**
 * This class allows you to use generate dynamic classes such as stdClass
 * with custom names and properties (+values)
 *
 * @author Jonas Sciangula Street <joni2back {at} gmail.com>
 * @todo Workaround to allow objects as parameter
 *
 * @usage
 *     $crazyClass = InstanceBuilder::build('CrazyClass');
 *     $crazyClass = InstanceBuilder::build('CrazyClass', array(
 *       'user' => 'admin',
 *       'age' => 24,
 *       'allowed' => true,
 *       'data' => array('country' => 'arg'),
 *       'main'
 *     ));
 */

abstract class InstanceBuilder
{

    /**
     * Initiator, build a basic instance with custom name
     *
     * @param type $className
     * @param array $attrs
     * @return object
     */
    public static function build($className, array $attrs = array(), $namespace = null)
    {
        $attrsString = '';
        if (! self::validateName($className)) {
            return;
        }
        foreach ($attrs as $attr => $val) {
            if (is_object($attr) || is_object($val)) {
                continue;
            }
            if (! self::validateName($attr)) {
                $attr = $val;
                $val = null;
            }
            $attrsString .= sprintf("public $%s = %s;\n", $attr, var_export($val, true));
        }
        $evalString = sprintf("class %s { %s }", $className, $attrsString);

        $namespace = preg_replace('/^\\\/', '', $namespace);
        if (self::validateNamespace($namespace)) {
            $evalString = sprintf("namespace %s;\n%s", $namespace, $evalString);
            $className = sprintf("%s\%s", $namespace, $className);
        }

        eval($evalString);
        return new $className;
    }

    /**
     * @param string $name
     * @return bool
     */
    protected static function validateName($name)
    {
        return preg_match('/^[a-zA-Z\_]{1}+([\_a-zA-Z0-9]+)*$/', $name);
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function validateNamespace($name)
    {
        $path = explode('\\', $name);
        foreach ($path as $part) {
            if (! self::validateName($part)) {
                return false;
            }
        }
        return true;
    }
}
