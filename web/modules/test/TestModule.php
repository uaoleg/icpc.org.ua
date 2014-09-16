<?php

namespace web\modules\test;

class TestModule extends \web\ext\WebModule
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default controller
        $this->defaultController = 'lang';
    }

}