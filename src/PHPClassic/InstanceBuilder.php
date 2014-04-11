<?php

namespace PHPClassic;

/**
 * This class allows you to use generate dynamic classes such as stdClass
 * with custom names and properties (+values)
 *
 * @author Jonas Sciangula Street <joni2back {at} gmail.com>
 * @todo Workaround to allow objects as parameter
 * @todo Support namespaces
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
     * @return \PHPClassic\className
     */
    public static function build($className, array $attrs = array())
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

        eval(sprintf("class %s { %s }", $className, $attrsString));
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
}
