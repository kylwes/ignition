<?php

namespace Kylwes\Ignition\Cards;

use Kylwes\Ignition\Plugin;

class Card extends Plugin {

    public $name = 'Card Name';


    public function __construct() {
        $this->add_action('wp_dashboard_setup', array($this, 'init'));
    }

    public function init()
    {
        global $wp_meta_boxes;
        wp_add_dashboard_widget('custom_help_widget', $this->name, array($this, 'render'));
    }
 
    public function render()
    {
        echo '<p>Welcome to Custom Blog Theme! Need help? Contact the developer <a href="mailto:yourusername@gmail.com">here</a>. For WordPress Tutorials visit: <a href="http://www.wpbeginner.com" target="_blank">WPBeginner</a></p>';
    }

}