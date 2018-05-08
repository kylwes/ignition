<?php

namespace Kylwes\Ignition\Settings\Fields;


class Textarea extends Field {

    public function render()
    {
        echo "<textarea cols='30' rows='10' name='{$this->name}'>{$this->get_value()}</textarea>";
    }
}


