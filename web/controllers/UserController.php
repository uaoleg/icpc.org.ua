<?php

namespace web\controllers;

use \common\models\User;
use \common\models\School;
use \common\models\User\InfoCoach;
use \common\models\User\InfoStudent;

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
        $firstNameUk       = $this->request->getPost('firstNameUk');
        $middleNameUk       = $this->request->getPost('middleNameUk');
        $lastNameUk        = $this->request->getPost('lastNameUk');
        $firstNameEn       = $this->request->getPost('firstNameEn');
        $middleNameEn       = $this->request->getPost('middleNameEn');
        $lastNameEn        = $this->request->getPost('lastNameEn');
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
                'firstNameUk'  => $firstNameUk,
                'middleNameUk' => $middleNameUk,
                'lastNameUk'   => $lastNameUk,
                'firstNameEn'  => $firstNameEn,
                'middleNameEn' => $middleNameEn,
                'lastNameEn'   => $lastNameEn,
                'schoolId'     => $schoolId,
                'type'         => $type,
                'coordinator'  => $coordinator
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
                'firstNameUk'       => $user->firstNameUk,
                'middleNameUk'      => $user->middleNameUk,
                'lastNameUk'        => $user->lastNameUk,
                'firstNameEn'       => $user->firstNameEn,
                'middleNameEn'      => $user->middleNameEn,
                'lastNameEn'        => $user->lastNameEn,
                'email'             => $user->email,
                'schoolId'          => $user->schoolId,
                'type'              => $user->type,
                'coordinator'       => $user->coordinator,
                'coordinatorLabel'  => $coordinatorLabel,
                'schools'           => $schools
            ));
        }
    }

    public function actionAdditional_Uk()
    {
        $lang = 'uk';
        $user = \yii::app()->user->getInstance();
        if ($user->type === 'student') {
            $this->render('additional_student', array(
                'lang' => $lang,
                'info' => $user->info
            ));
        } elseif ($user->type === 'coach') {
            $this->render('additional_coach', array(
                'lang' => $lang,
                'info' => $user->info
            ));
        }
    }

    public function actionAdditional_En()
    {
        $lang = 'en';
        $user = \yii::app()->user->getInstance();
        if ($user->type === 'student') {
            $this->render('additional_student', array(
                'lang' => $lang,
                'info' => $user->info
            ));
        } elseif ($user->type === 'coach') {
            $this->render('additional_coach', array(
                'lang' => $lang,
                'info' => $user->info
            ));
        }
    }

}