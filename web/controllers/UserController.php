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
        $newPassword       = $this->request->getPost('newPassword');
        $repeatNewPassword = $this->request->getPost('repeatNewPassword');
        $schoolId          = $this->request->getPost('schoolId');
        $type              = $this->request->getPost('type');
        $coordinator       = $this->request->getPost('coordinator');
        $user = \yii::app()->user->getInstance();

        $wrongPassword = false;
        if ($this->request->isPostRequest) {

            $user->setAttributes(array(
                'firstName'   => $firstName,
                'lastName'    => $lastName,
                'schoolId'    => $schoolId,
                'type'        => $type,
                'coordinator' => $coordinator
            ), false);
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