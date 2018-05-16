<?php

namespace Kylwes\Ignition\Settings;

use Kylwes\Ignition\User;
use Kylwes\Ignition\Store;
use Kylwes\Ignition\Plugin;
use Kylwes\Ignition\Admin\Dashboard;
use Kylwes\Ignition\Settings\Fields\File;
use Kylwes\Ignition\Settings\Fields\Field;
use Kylwes\Ignition\Settings\Fields\Input;
use Kylwes\Ignition\Settings\Notification;
use Kylwes\Ignition\Settings\Fields\Select;
use Kylwes\Ignition\Settings\Fields\Checkbox;
use Kylwes\Ignition\Settings\Fields\Modifier;
use Kylwes\Ignition\Settings\Fields\Textarea;
use Kylwes\Ignition\Settings\Fields\Checkboxgroup;

class Page extends Plugin
{

    public $page_name;

    public $page_slug;

    public $page_modifier = [];

    public $page_permission = 'edit_posts';



    public function __construct()
    {
        $this->add_action('admin_init', array( $this, 'saveOptions' ));
        $this->add_action('admin_menu', array( $this, 'addMenu' ));
    }

    public function saveOptions()
    {
        $keys = [];
        if (isset($_POST[$this->page_slug])) {
            foreach ($_POST as $key => $value) {
                $keys[] = $key;
            }
            Store::set_value(self::format($this->page_slug, $this->page_modifier), $keys);

            new Notification('updated', sprintf(__('%s succesfully geupdated', 'ohm'), $this->page_name));
        }
    }

    public function addMenu()
    {
        add_options_page($this->page_slug, $this->page_name, $this->page_permission, sanitize_title($this->page_slug), array( $this, 'render' ));
    }

    public function render()
    {
        global $submenu, $menu, $pagenow, $wp_roles;
        // Silence is golden
    }



    public function get_page_fields()
    {
        return Store::get_value(self::format($this->page_slug, $this->page_modifier), []);
    }

    public function get_page_values()
    {
        $fields = $this->get_page_fields();
        $data = [];
        foreach ($fields as $field) {
            $data[] = Store::get_value(self::format($this->page_slug, $this->page_modifier) . '_' . $field, '');
        }
        return $data;
    }

    public static function format($namespace, $modifier)
    {
        return implode('', $modifier) . $namespace;
    }



    public function input($name, $default = '')
    {
        return (new Input($name, $this->page_slug, $this->page_modifier, $default))->render();
    }

    public function textarea($name, $default = '')
    {
        return (new Textarea($name, $this->page_slug, $this->page_modifier, $default))->render();
    }

    public function checkbox($name, $default = '')
    {
        return (new Checkbox($name, $this->page_slug, $this->page_modifier, $default))->render();
    }

    public function file($name, $default = '')
    {
        return (new File($name, $this->page_slug, $this->page_modifier, $default))->render();
    }

    public function select($name, $options, $default = '')
    {
        return (new Select($name, $this->page_slug, $this->page_modifier, $default, $options))->render();
    }


    public function modifier($name, $options, $default = '')
    {
        return (new Modifier($name, $this->page_slug, $this->page_modifier, $default, $options))->render();
    }

    public function checkbox_group($name, $val)
    {
        return (new Checkboxgroup($name, $this->page_slug, $this->page_modifier, $val))->render();
    }
}
