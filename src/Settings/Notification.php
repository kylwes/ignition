<?php

namespace Kylwes\Ignition\Settings;

use Kylwes\Ignition\Plugin;

class Notification extends Plugin {

    public function __construct($type, $message) {
        $this->type = $type;
        $this->message = $message;

        add_action( 'admin_notices', array($this, 'render'));
    }


    public function render() {
        ?>
        <div class="<?= $this->type ?> notice is-dismissable">
            <p><?= $this->message ?></p>
        </div>
        <?php
    }
}


