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
     * @param bool $createGetters
     * @return object
     */
    public static function build($className, array $attrs = array(), $namespace = null, $createGetters = true)
    {
        $attrsString = '';
        $methdString = '';
        if (! static::validateName($className)) {
            return;
        }
        foreach ($attrs as $attr => $val) {
            if (is_object($attr) || is_object($val)) {
                continue;
            }
            if (! static::validateName($attr)) {
                if (! static::validateName($val)) {
                    continue;
                }
                $attr = $val;
                $val = null;
            }
            $attrsString .= static::buildProperty($attr, $val);
            if ($createGetters) {
                $methdString .= static::buildGetter($attr);
                $methdString .= static::buildSetter($attr);
            }
        }
        $evalString = sprintf("class %s {\n%s\n%s\n}", $className, $attrsString, $methdString);

        $namespace = preg_replace('/^\\\/', '', $namespace);
        if (static::validateNamespace($namespace)) {
            $evalString = sprintf("namespace %s;\n%s", $namespace, $evalString);
            $className = sprintf("%s\%s", $namespace, $className);
        }
        eval($evalString);
        return new $className;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return string
     */
    protected static function buildProperty($name, $value)
    {
        return sprintf("public $%s=%s;\n", $name, var_export($value, true));
    }

    /**
     * @param string $name
     * @return string
     */
    protected static function buildGetter($name)
    {
        return sprintf("function get%s() {return \$this->%s;}\n", ucfirst($name), $name);
    }

    /**
     * @param string $name
     * @return string
     */
    protected static function buildSetter($name)
    {
        return sprintf("function set%s(\$val) {\$this->%s=\$val; return \$this;}\n", ucfirst($name), $name);
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
            if (! static::validateName($part)) {
                return false;
            }
        }
        return true;
    }
}
