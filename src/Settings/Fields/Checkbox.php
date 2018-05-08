<?php

namespace Kylwes\Ignition\Settings\Fields;

use Kylwes\Ignition\Store;


class Checkbox extends Field {

    public function render()
    {
        $checked = '';
        if($this->field_in_array()) {
            $checked = 'checked';
        }
        
        echo "<input type='checkbox' {$checked} name='{$this->name}'>";
    }
}


