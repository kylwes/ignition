<?php

namespace Kylwes\Ignition\Hooks;

class Filter
{

    public $hook = 'init';

    public $priority = 10;

    public $arguments = 0;

    public function __construct()
    {
        add_filter($this->hook, array($this, 'filter'), $this->priority, $this->arguments);
    }
}
