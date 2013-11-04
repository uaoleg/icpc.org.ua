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
        // Get params
        $firstName         = $this->request->getPost('firstName');
        $lastName          = $this->request->getPost('lastName');
        $currentPassword   = $this->request->getPost('currentPassword');
        $password          = $this->request->getPost('password');
        $passwordRepeat    = $this->request->getPost('passwordRepeat');
        $schoolId          = $this->request->getPost('schoolId');
        $type              = $this->request->getPost('type');
        $coordinator       = $this->request->getPost('coordinator');

        // Get logged in user
        $user = \yii::app()->user->getInstance();

        // Update user data
        if ($this->request->isPostRequest) {

            // Set new attributes
            $user->setAttributes(array(
                'firstName'   => $firstName,
                'lastName'    => $lastName,
                'schoolId'    => $schoolId,
                'type'        => $type,
                'coordinator' => $coordinator
            ), false);
            $user->validate();

            // Set new password
            if (!empty($password)) {
                if ($user->checkPassword($currentPassword)) {
                    $user->setPassword($password, $passwordRepeat);
                } else {
                    $user->addError('currentPassword', \yii::t('app', '{attr} is incorrect', array(
                        '{attr}' => $user->getAttributeLabel('password'),
                    )));
                }
            }

            // Save chagnes
            if (!$user->hasErrors()) {
                $user->save();
            }

            // Render json
            $this->renderJson(array(
                'errors' => $user->hasErrors() ? $user->getErrors() : false
            ));
        }

        // Show form
        else {

            // Get list of schools
            $criteria = new \EMongoCriteria();
            $criteria->sort('fullNameUk', \EMongoCriteria::SORT_ASC);
            $schools = School::model()->findAll($criteria);

            // Set coordinator label
            switch ($user->coordinator) {
                case User::ROLE_COORDINATOR_UKRAINE:
                    $coordinatorLabel = \yii::t('app', 'Ukraine');
                    break;
                case User::ROLE_COORDINATOR_REGION:
                    $coordinatorLabel = \yii::t('app', 'Region');
                    break;
                case User::ROLE_COORDINATOR_STATE:
                    $coordinatorLabel = \yii::t('app', 'State');
                    break;
                default:
                    $coordinatorLabel = \yii::t('app', 'Coordinator');
                    break;
            }

            // Render view
            $this->render('me', array(
                'firstName'         => $user->firstName,
                'lastName'          => $user->lastName,
                'email'             => $user->email,
                'schoolId'          => $user->schoolId,
                'type'              => $user->type,
                'coordinator'       => $user->coordinator,
                'coordinatorLabel'  => $coordinatorLabel,
                'schools'           => $schools
            ));
        }
    }

}