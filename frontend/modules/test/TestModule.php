<?php

namespace frontend\modules\test;

class TestModule extends \yii\base\Module
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
