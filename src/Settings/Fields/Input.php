<?php

namespace Kylwes\Ignition\Settings\Fields;


class Input extends Field {

    public function render()
    {
        echo "<input type='text' name='{$this->name}' value='{$this->get_value()}'>";
    }
}


