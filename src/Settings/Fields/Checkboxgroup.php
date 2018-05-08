<?php

namespace Kylwes\Ignition\Settings\Fields;

use Kylwes\Ignition\Store;


class Checkboxgroup extends Field {


    public function __construct($name, $namespace, $modifier, $value)
    {
        parent::__construct($name, $namespace, $modifier);
        
        $this->value = $value;
    }
    public function render()
    {
        $checked = '';
        // if($this->field_in_array()) {
        //     $checked = 'checked';
        // }
        
        echo "<input type='checkbox' {$checked} name='{$this->name}[]' value='{$this->value}'>";
    }
}


