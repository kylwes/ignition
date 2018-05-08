<?php

namespace Kylwes\Ignition\Settings\Fields;

use Kylwes\Ignition\Store;
use Kylwes\Ignition\Plugin;
use Kylwes\Ignition\Settings\Page;
use Kylwes\Ignition\Settings\Notification;


class Field extends Plugin {
    
    public $name;
    public $namespace;
    public $modifier;
    public $default;

    public static $fields = [];


    public function __construct($name, $namespace, $modifier, $default = '')
    {
        $this->name = $name;
        $this->namespace = $namespace;
        $this->modifier = $modifier;
        $this->default = $default;

        if(!in_array($this->name, self::$fields)) {
            self::$fields[] = $this->name;
        }


        $this->set_value();
    }

    public function set_value()
    {
        $name = str_replace('[]', '', $this->name);
        if(isset($_POST[$name])) {
            Store::set_value(Page::format($this->namespace, $this->modifier) . '_' . $name, $_POST[$name]);
        }
    }

    public function get_value() {
        if (Store::get_value(Page::format($this->namespace, $this->modifier) . '_' . $this->name, false)) {
            return Store::get_value(Page::format($this->namespace, $this->modifier) . '_' . $this->name);
        } else {
            return $this->default;
        }
    }

    public function equal_to_value($val, $output = 'selected') {
        return ($this->get_value() == $val) ? $output : '';
    }

    public function equal_to_GET($val, $name, $output = 'selected') {
        return (isset($_GET[$name]) && $_GET[$name] == $val) ? $output : '';
    }

    public function field_in_array()
    {
        return (in_array($this->name, $this->string_to_array(Store::get_value(Page::format($this->namespace, $this->modifier), []))));
    }

    public function string_to_array($values) {
        return (is_string($values)) ? json_decode($values) : $values;
    }

}