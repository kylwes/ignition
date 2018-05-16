<?php

namespace Kylwes\Ignition\Hooks;

class Action
{

    public $hook = 'init';

    public $priority = 10;

    public $arguments = 0;

    public function __construct()
    {
        add_action($this->hook, array($this, 'action'), $this->priority, $this->arguments);
    }
}
