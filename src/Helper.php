<?php
namespace Kylwes\Ignition;

class Helper extends Plugin
{


    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
        (substr($haystack, -$length) === $needle);
    }


    public static function equal_to_GET($val, $name, $output = 'selected')
    {
        return (isset($_GET[$name]) && $_GET[$name] == $val) ? $output : '';
    }

    public static function string_to_array($values)
    {
        return (is_string($values)) ? json_decode($values) : $values;
    }
}
