<?php
namespace Kylwes\Ignition;

use Kylwes\Ignition\Settings\Page;

class Store extends Plugin
{


    private static $suffix = '';

    private static $prefix = '';

    private $modifiers = [];


    public static function all($namespace, $modifier = [])
    {
        $items = self::get_value(Page::format($namespace, $modifier));

        $data = [];
        foreach ($items as $item) {
            $data[] = self::get_value(Page::format($namespace, $modifier) . '_' . $item);
        }
        return $data;
    }

    public static function get($key, $namespace, $modifier = [])
    {
        $items = self::get_value(Page::format($namespace, $modifier));

        if ($items != null && is_array($items)) {
            if (in_array($key, $items)) {
                return self::get_value(Page::format($namespace, $modifier) . '_' . $key);
            }
        }
    }

    public static function get_value($name, $res = '', $post_id = null)
    {
        $getter = get_option(self::$prefix . $name . self::$suffix);

        if ($getter == null) {
            return $res;
        } else {
            return $getter;
        }
    }

    public static function set_value($name, $data, $post_id = null)
    {
        $getter = get_option(self::$prefix . $name . self::$suffix);
        if ($getter == null) {
            add_option(self::$prefix . $name . self::$suffix);
        }
        update_option(self::$prefix . $name . self::$suffix, $data);
    }

    public static function format_get_all($namespace, $modifiers = [])
    {
    }

    public static function format_get_one()
    {
    }

    public static function format_set_one()
    {
    }
}
