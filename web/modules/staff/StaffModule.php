<?php

namespace web\modules\staff;

class StaffModule extends \web\ext\WebModule
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