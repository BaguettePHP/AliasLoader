<?php

namespace Teto;

/**
 * Class aliasing for provide flat namespace on your application
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2015 USAMI Kenta
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
final class AliasLoader
{
    private static $is_registered = false;

    private static $alias_map = [];

    /**
     * @param string $from Fully qualified class name
     * @param string $to   Alias class name
     */
    public static function add($from, $to)
    {
        if (strpos($from, '\\') === 0) {
            $from = substr($from, 1);
        }

        self::$alias_map[$to] = $from;

        if (!self::$is_registered) {
            self::registerAutoloader();
        }
    }

    /**
     * @param array $alias_map [string $fqn_class_name => string $alias_class_name]
     */
    public static function register(array $alias_map)
    {
        foreach ($alias_map as list($from, $to)) {
            self::add($from, $to);
        }
    }

    public static function clear()
    {
        self::$alias_map = [];
    }

    public static function unregisterAutoloader()
    {
        if (self::$is_registered) {
            spl_autoload_unregister([self::class, 'autoload']);
            self::$is_registered = false;
        }
    }

    public static function registerAutoloader()
    {
        if (self::$is_registered) {
            return;
        }

        spl_autoload_register([self::class, 'autoload'], true, false);
        self::$is_registered = true;
    }

    public static function autoload($class)
    {
        if ($resolved = self::resolve(self::$alias_map, $class)) {
            class_alias($resolved, $class);
        }
    }

    /**
     * @param  array        $alias_map
     * @param  string       $input_class
     * @return string|false
     */
    public static function resolve(array $alias_map, $input_class)
    {
        $class = $input_class;

        while (true) {
            if (isset($alias_map[$class])) {
                return '\\' . $alias_map[$class];
            }

            if (strpos($class, '\\') === false) {
                break;
            }

            list($_, $class) = explode('\\', $class, 2);
            //var_dump([$_ => $class, $alias_map]);
        }

        return false;
    }
}
