<?php

namespace web\controllers;

use \common\models\User;

class UserController extends \web\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'me';

        // Set active main menu item
        $this->setNavActiveItem('main', '');
    }

    /**
     * Profile page
     */
    public function actionMe()
    {
        // Render view
        $this->render('me', array(
            'user' => \yii::app()->user->getInstance(),
        ));
    }

}

