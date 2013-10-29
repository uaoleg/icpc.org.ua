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
        $sessionUser = \yii::app()->user->getInstance();

        $firstName             = $this->request->getPost('firstName');
        $lastName              = $this->request->getPost('lastName');
        $currentPassword       = $this->request->getPost('currentPassword');
        $newPassword           = $this->request->getPost('newPassword');
        $repeatNewPassword     = $this->request->getPost('repeatNewPassword');

        $wrongPassword = false;
        if ($this->request->isPostRequest) {
            $criteria = array('_id' => $sessionUser->_id);
            $user = User::model()->find($criteria);
            $user->firstName   = $firstName;
            $user->lastName    = $lastName;
            if (!empty($currentPassword)) {
                if ($user->checkPassword($currentPassword)) {
                    $user->setPassword($newPassword, $repeatNewPassword);
                } else {
                    $wrongPassword = true;
                }
            }
            $user->save();
            if ($wrongPassword) {
                $user->addError('currentPassword', \yii::t('app', 'Password is incorrect'));
            }
            $this->renderJson(array(
                'errors' => $user->hasErrors() ? $user->getErrors() : false
            ));
        } else {
            // Render view
            $this->render('me', array(
                'firstName' => $firstName ? $firstName : $sessionUser->firstName,
                'lastName'  => $lastName ? $lastName : $sessionUser->lastName,
                'email'     => $sessionUser->email,
            ));
        }
    }

}

