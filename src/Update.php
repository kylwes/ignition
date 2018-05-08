<?php

namespace Kylwes\Ignition;

use Kylwes\Ignition\Plugin;

class Update extends Plugin {
    /**
     * The plugin current version
     * @var string
     */
    public $current_version;

    /**
     * The plugin remote update path
     * @var string
     */
    public $update_path;

    /**
     * Plugin Slug (plugin_directory/plugin_file.php)
     * @var string
     */
    public $plugin_slug;

    /**
     * Plugin name (plugin_file)
     * @var string
     */
    public $slug;

    /**
     * Initialize a new instance of the WordPress Auto-Update class
     * @param string $current_version
     * @param string $update_path
     * @param string $plugin_slug
     */
    function __construct($current_version, $update_path, $plugin_slug) {
        // Set the class public variables
        $this->current_version = $current_version;
        $this->update_path = $update_path;
        $this->plugin_slug = $plugin_slug;
        list ($t1, $t2) = explode('/', $plugin_slug);
        $this->slug = str_replace('.php', '', $t2);
        // define the alternative API for updating checking
        // add_filter('pre_set_site_transient_update_plugins', array($this, 'check_update'));

        // Define the alternative response for information checking
        add_filter('plugins_api', array($this, 'misha_plugin_info'), 20, 3);
        add_filter('site_transient_update_plugins', array($this, 'misha_push_update'));
        add_action( 'upgrader_process_complete', array($this, 'misha_after_update'), 10, 2 );


    }

    public function misha_after_update( $upgrader_object, $options ) {
        if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
            // just clean the cache when new plugin version is installed
            delete_transient( 'misha_upgrade_' . $this->slug );
        }
    }

   
    public function misha_plugin_info( $res, $action, $args ){
 
        // do nothing if this is not about getting plugin information
        if( $action !== 'plugin_information' )
            return false;
     
        // do nothing if it is not our plugin	
        if( $this->slug !== $args->slug )
            return $res;
     
        // trying to get from cache first, to disable cache comment 18,28,29,30,32
        if( false == $remote = get_transient( 'misha_upgrade_' . $this->slug ) ) {
     
            // info.json is the file with the actual plugin information on your server
            $remote = wp_remote_get( $this->update_path, array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/json'
                ) )
            );
     
            if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
                set_transient( 'misha_upgrade_' . $this->slug, $remote, 43200 ); // 12 hours cache
            }
     
        }
     
        if( $remote ) {
     
            $remote = json_decode( $remote['body'] );
            $res = new \stdClass();
            $res->name = $remote->name;
            $res->slug = $this->slug;
            $res->version = $remote->version;
            $res->tested = $remote->tested;
            $res->requires = $remote->requires;
            $res->author = $remote->author; // I decided to write it directly in the plugin
            $res->author_profile = '<a href="' . $remote->author_homepage . '">' . $remote->author . '</a>'; // WordPress.org profile
            $res->download_link = $remote->download_url;
            $res->trunk = $remote->download_url;
            $res->last_updated = $remote->last_updated;
            $res->sections = array(
                'description' => $remote->sections->description, // description tab
                'installation' => $remote->sections->installation, // installation tab
                'changelog' => $remote->sections->changelog, // changelog tab
                // you can add your custom sections (tabs) here 
            );
     
            // in case you want the screenshots tab, use the following HTML format for its content:
            // <ol><li><a href="IMG_URL" target="_blank"><img src="IMG_URL" alt="CAPTION" /></a><p>CAPTION</p></li></ol>
            if( !empty( $remote->sections->screenshots ) ) {
                $res->sections['screenshots'] = $remote->sections->screenshots;
            }
     
            $res->banners = array(
                'low' => 'https://YOUR_WEBSITE/banner-772x250.jpg',
                'high' => 'https://YOUR_WEBSITE/banner-1544x500.jpg'
            );
                   return $res;
     
        }
     
        return false;
     
    }

    public function misha_push_update( $transient ){
 
        if ( empty($transient->checked ) ) {
                return $transient;
            }
     
        // trying to get from cache first, to disable cache comment 10,20,21,22,24
        if( false == $remote = get_transient( 'misha_upgrade_' . $this->slug ) ) {
     
            // info.json is the file with the actual plugin information on your server
            $remote = wp_remote_get( $this->update_path, array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/json'
                ) )
            );
     
            if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
                set_transient( 'misha_upgrade_' . $this->slug, $remote, 43200 ); // 12 hours cache
            }
     
        }
     
        if( $remote ) {
     
            $remote = json_decode( $remote['body'] );
     
            // your installed plugin version should be on the line below! You can obtain it dynamically of course 
            if( $remote && version_compare( $this->current_version, $remote->version, '<' ) && version_compare($remote->requires, get_bloginfo('version'), '<=' ) ) {
                $res = new \stdClass();
                $res->slug = $this->slug;
                $res->plugin = 'ohm/ohm.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
                $res->new_version = $remote->version;
                $res->tested = $remote->tested;
                $res->package = $remote->download_url;
                $res->url = $this->update_path;
                       $transient->response[$res->plugin] = $res;
                       //$transient->checked[$res->plugin] = $remote->version;
                   }
     
        }
            return $transient;
    }
}