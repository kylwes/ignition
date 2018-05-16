<?php
namespace Kylwes\Ignition;

use Kylwes\Ignition\Helper;

class User
{

    public static $current;
    public static $meta;
    public static $roles = [];


    public static $admin;

    public function __construct($admin)
    {
        self::$admin = $admin;

        add_action('init', array($this, 'getUserInfo'));
    }


    public function getUserInfo()
    {
        self::$current = wp_get_current_user();
        self::$meta = get_userdata(self::$current->ID);

        if (self::$meta != null) {
            self::$roles = self::$meta->roles;
        }
    }

    public static function isPermitted($admin)
    {
        return Helper::endsWith(self::$current->user_email, $admin);
    }
}
