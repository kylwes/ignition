<?php
namespace Kylwes\Ignition;

use Kylwes\Ignition\Helper;



class User extends Plugin {
   
    public static $current;
    public static $meta;
    public static $roles = [];

    public static $is_permitted;


    public function __construct() {

        add_action('init', array($this, 'get_user_info'));

    }


    public function get_user_info()
    {
        self::$current = wp_get_current_user();
        self::$meta = get_userdata(self::$current->ID);
        // var_dump(self::$current);
        self::$is_permitted = Helper::endsWith(self::$current->user_email, self::$admin);

        if(self::$meta != null) {
            self::$roles = self::$meta->roles;
    
        }
    }
}