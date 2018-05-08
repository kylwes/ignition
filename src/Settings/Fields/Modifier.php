<?php

namespace Kylwes\Ignition\Settings\Fields;


class Modifier extends Field {


    public function __construct($name, $namespace, $modifier, $default = '', $options = [])
    {
        parent::__construct($name, $namespace, $modifier, $default);
        
        $this->options = $options;
    }


    public function render()
    {
        echo "<select data-modifier='{$this->name}' type='text'>{$this->render_options()}</select>";
    }

    public function render_options()
    {
        $options = "";
        foreach($this->options as $key => $option)  {
            $options .= "<option value='{$key}' {$this->equal_to_GET($key, $this->name)} >{$option}</option>";
        }
        return $options;
    }
}


