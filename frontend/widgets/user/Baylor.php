<?php

namespace frontend\widgets\user;

use \frontend\widgets\BaseWidget;

class Baylor extends BaseWidget
{
    /**
     * Run widget
     */
    public function run()
    {
        return $this->render('baylor');
    }

}