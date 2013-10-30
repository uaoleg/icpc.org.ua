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
        $sessionUser = \yii::app()->user->getInstance();

        $firstName         = $this->request->getPost('firstName');
        $lastName          = $this->request->getPost('lastName');
        $currentPassword   = $this->request->getPost('currentPassword');
        $newPassword       = $this->request->getPost('newPassword');
        $repeatNewPassword = $this->request->getPost('repeatNewPassword');
        $schoolId          = $this->request->getPost('schoolId');
        $type              = $this->request->getPost('type');
        $coordinator       = $this->request->getPost('coordinator');

        $wrongPassword = false;
        if ($this->request->isPostRequest) {
            $criteria = array('_id' => $sessionUser->_id);
            $user = User::model()->find($criteria);
            $user->firstName   = $firstName;
            $user->lastName    = $lastName;
            $user->schoolId    = $schoolId;
            $user->type        = $type;
            $user->coordinator = $coordinator;
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
                'firstName'   => $firstName ? $firstName : $sessionUser->firstName,
                'lastName'    => $lastName ? $lastName : $sessionUser->lastName,
                'email'       => $sessionUser->email,
                'schoolId'    => $schoolId ? $schoolId : $sessionUser->schoolId,
                'type'        => $type ? $type : $sessionUser->type,
                'coordinator' => isset($sessionUser->coordinator) ? ucfirst(substr($sessionUser->coordinator, 12)) : 'Coordinator',
                'schools'     => $schools
            ));
        }
    }

}