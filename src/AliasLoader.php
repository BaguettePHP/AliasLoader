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
        if (strpos($from, '\\') !== 0) {
            $from = '\\' . $from;
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
        $namespace_class = $class;

        while (true) {
            if (isset(self::$alias_map[$namespace_class])) {
                class_alias(self::$alias_map[$namespace_class], $class, true);
                return true;
            }

            if (strpos($namespace_class, '\\') === false) {
                break;
            }

            list($_, $namespace_class) = explode('\\', $namespace_class, 2);
       }

        return false;
    }
}
