<?php

namespace Kylwes\Ignition\Settings\Fields;

use Kylwes\Ignition\Store;


class File extends Field {

    public function render()
    {
        echo "<div class='file-upload-wrapper' id='{$this->name}'  onclick='open_media_uploader_image({$this->name})'><input type='hidden' name='{$this->name}' value='{$this->get_value()}'><img class='ohm-thumbnail' src='{$this->get_value()}'></div>";
    }
}


