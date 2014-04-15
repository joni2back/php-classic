<?php

namespace PHPClassic;

/**
 * This class provides autoloader method that allow you to use namespaces
 * inclusion (such as import package in other languages).
 * Also you can add new inclusion dirs, or file extensions in a simple way
 *
 * @link http://php.net/function.spl-autoload-register.php
 * @link http://php.net/language.oop5.autoload.php
 * @author Jonas Sciangula Street <joni2back {at} gmail.com>
 *
 * @usage
 *      <?php
 *      //Application core, low level config file, etc
 *      ClassicLoader::addPath('/usr/local/zend/share/ZendFramework2/library');
 *      ClassicLoader::addExt('php5');
 *      ClassicLoader::register();
 */

final class ClassicLoader
{
    protected static $paths = array(__DIR__);
    protected static $exts = array('php');
    const DS = DIRECTORY_SEPARATOR;

    /**
     * @param string $class
     * @return void
     */
    public static function autoLoad($class)
    {
        $paths = explode('\\', $class);
        $classname = end($paths);
        array_pop($paths);
        $classpath = implode(self::DS, $paths);

        foreach (self::getExts() as $ext) {
            foreach (self::getPaths() as $path) {
                $filepath = sprintf('%s%s%s%s%s.%s',
                    $path, self::DS, $classpath, self::DS, $classname, $ext
                );
                if (file_exists($filepath)) {
                    require_once $filepath;
                    return;
                }
            }
        }
    }

    /**
     * @param type $prepend
     * @return void
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoLoad'));
    }

    /**
     * @return void
     */
    public function unregister()
    {
        spl_autoload_unregister(array(__CLASS__, 'autoLoad'));
    }

    /**
     * @return void
     */
    public static function reset()
    {
        static::$paths = array(__DIR__);
        static::$exts = array('php');
    }

    /**
     * @return void
     * @param mixed $path
     */
    public static function addPath($path)
    {
        if (is_array($path)) {
            foreach ($path as $pathstr) {
                self::addPath($pathstr);
            }
        } elseif (is_string($path)) {
            ! is_dir($path) ?: self::$paths[] = realpath($path);
        }
    }

    /**
     * @return array
     */
    public static function getPaths()
    {
        return array_unique(self::$paths);
    }

    /**
     * @param string $ext
     * @return void
     */
    public static function addExt($ext)
    {
        if (is_array($ext)) {
            foreach ($ext as $extstr) {
                self::addExt($extstr);
            }
        } elseif (is_scalar($ext)) {
            self::$exts[] = $ext;
        }
    }

    /**
     * @return array
     */
    public static function getExts()
    {
        return array_unique(self::$exts);
    }

}
