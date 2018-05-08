<?php
namespace Kylwes\Ignition;

use Kylwes\Ignition\User;
use Kylwes\Ignition\Update;
use Kylwes\Ignition\Cards\Help;
use Kylwes\Ignition\Admin\Dashboard;
use Kylwes\Ignition\Settings\Pages\ohm_menu\Menu;
use Kylwes\Ignition\Settings\Pages\ohm_settings\Settings;

  /**
   * Plugin
   * 
   * 
   * @package    Ignition
   * @author     Kylwes
   */
class Plugin {


    /**
     * Admin
     * 
     * This will be used to tell User::$is_volt what email domain to check
     * 
     * @access public
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    public static $admin;


    /**
     * Version
     * 
     * The plugin version
     * 
     * @access private
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    private $version;


    /**
     * Plugin Name
     * 
     * The name of the plugin
     * 
     * @access private
     * 
     * @var string
     * 
     * @since 1.0.0
     */
    private $plugin_name;


    /**
     * Update Path
     * 
     * @see Kylwes\Ignition\Update
     * 
     * @access private
     * 
     * @var string
     * 
     * @since 1.0.0
     * 
     * @deprecated No longer used by internal code and not recommended.
     */
	private $update_path;

    private $update_file;
    /**
     * Filters
     * 
     * This variable will group all filters to execute them all at once on the WordPress 'init' hook
     * 
     * @access private
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    private static $filters = [];


    /**
     * Actions
     * 
     * This variable will group all actions to execute them all at once on the WordPress 'init' hook
     * 
     * @access private
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    private static $actions = [];


     /**
     * Initial setup of the plugin
     * 
     * @access public
     * 
     * @since 1.0.0
     */
    public function __construct() {


        // Make sure every class used is called
        $this->init_plugins();

        add_action('init', 'check_for_plugin_updates');
        // Execute all $filters and $actions on 'init'
        add_action('init', function()
        {
            foreach(self::$filters as $filter) {
                add_filter($filter['hook'], $filter['class'], $filter['priority'], $filter['args']);
            }
            foreach(self::$actions as $action) {
                add_action($action['hook'], $action['class'], $filter['priority'], $filter['args']);
            }
        });
    }

    public function check_for_plugin_updates() {
        new Update($this->version, $this->update_path, plugin_basename(__FILE__));
    }


    /**
     * Init Plugins
     * 
     * Load all plugin dependicies
     * 
     * @access public
     * 
     * @since 1.0.0
     */
    public function init_plugins() {


    }


    /**
     * Add Action
     * 
     * Add Action to the array of actions
     * 
     * @access public
     * 
     * @param string        $hook       The WordPress hook to add the action to
     * @param array|string  $class      The function to execute when the hook is called
     * @param integer       $priority   The priority for the function
     * @param integer       $args       Amount of arguments the function takes 
     * 
     * @since 1.0.0
     */
    public function add_action($hook, $class, $priority = 10, $args = 1) {
        self::$actions[] = [
            'hook' => $hook,
            'class' => $class,
            'priority' => $priority,
            'args' => $args
        ];
    }

    /**
     * Add Filter
     * 
     * Add Filter to the array of filters
     * 
     * @access public
     * 
     * @param string        $hook       The WordPress hook to add the filter to
     * @param array|string  $class      The function to execute when the hook is called
     * @param integer       $priority   The priority for the function
     * @param integer       $args       Amount of arguments the function takes 
     * 
     * @since 1.0.0
     */
    public function add_filter($hook, $class, $priority = 10, $args = 1) {
        self::$filters[] = [
            'hook' => $hook,
            'class' => $class,
            'priority' => $priority,
            'args' => $args
        ];
    }

}