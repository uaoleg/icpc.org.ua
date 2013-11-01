<?php

namespace web\controllers;

use \common\models\User,
    \common\models\School;

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
        $firstName         = $this->request->getPost('firstName');
        $lastName          = $this->request->getPost('lastName');
        $currentPassword   = $this->request->getPost('currentPassword');
        $password          = $this->request->getPost('password');
        $passwordRepeat    = $this->request->getPost('passwordRepeat');
        $schoolId          = $this->request->getPost('schoolId');
        $type              = $this->request->getPost('type');
        $coordinator       = $this->request->getPost('coordinator');
        $user = \yii::app()->user->getInstance();

        if ($this->request->isPostRequest) {

            $user->setAttributes(array(
                'firstName'   => $firstName,
                'lastName'    => $lastName,
                'schoolId'    => $schoolId,
                'type'        => $type,
                'coordinator' => $coordinator
            ), false);
            if (!empty($password)) {
                if ($user->checkPassword($currentPassword)) {
                    $user->setPassword($password, $passwordRepeat);
                    if (!$user->hasErrors()) {
                        $user->save();
                    }
                } else {
                    $user->addError('currentPassword', \yii::t('app', '{attr} is incorrect', array(
                        '{attr}' => $user->getAttributeLabel('password')
                    )));
                }
            }

            $this->renderJson(array(
                'errors' => $user->hasErrors() ? $user->getErrors() : false
            ));
        } else {
            // Get list of schools
            $criteria = new \EMongoCriteria();
            $criteria->sort('fullNameUk', \EMongoCriteria::SORT_ASC);
            $schools = School::model()->findAll($criteria);
            // Render view
            $this->render('me', array(
                'firstName'   => $user->firstName,
                'lastName'    => $user->lastName,
                'email'       => $user->email,
                'schoolId'    => $user->schoolId,
                'type'        => $user->type,
                'coordinator' => isset($user->coordinator) ? ucfirst(substr($user->coordinator, 12)) : 'Coordinator',
                'schools'     => $schools
            ));
        }
    }

}