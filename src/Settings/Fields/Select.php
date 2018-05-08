<?php

namespace Kylwes\Ignition\Settings\Fields;


class Select extends Field {


    public function __construct($name, $namespace, $modifier, $default = '', $options = [])
    {
        parent::__construct($name, $namespace, $modifier, $default);
        
        $this->options = $options;
    }


    public function render()
    {
        echo "<select type='text' name='{$this->name}'>{$this->render_options()}</select>";
    }

    public function render_options()
    {
        $options = "";
        foreach($this->options as $key => $option)  {
            $options .= "<option value='{$key}' {$this->equal_to_value($key)} >{$option}</option>";
        }
        return $options;
    }
}


