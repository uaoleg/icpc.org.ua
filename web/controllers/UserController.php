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
        $middleNameUk      = $this->request->getPost('middleNameUk');
        $lastNameUk        = $this->request->getPost('lastNameUk');
        $firstNameEn       = $this->request->getPost('firstNameEn');
        $middleNameEn      = $this->request->getPost('middleNameEn');
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

    /**
     * Page for additional information in ukrainian
     */
    public function actionAdditional_Uk()
    {
        $lang = 'uk';
        $user = \yii::app()->user->getInstance();
        if ($user->type === User::ROLE_STUDENT) {
            $this->render('additional_student', array(
                'lang' => $lang,
                'info' => $user->getInfo($lang)
            ));
        } elseif ($user->type === User::ROLE_COACH) {
            $this->render('additional_coach', array(
                'lang' => $lang,
                'info' => $user->getInfo($lang)
            ));
        }
    }

    /**
     * Page for additional information in english
     */
    public function actionAdditional_En()
    {
        $lang = 'en';
        $user = \yii::app()->user->getInstance();
        if ($user->type === User::ROLE_STUDENT) {
            $this->render('additional_student', array(
                'lang' => $lang,
                'info' => $user->getInfo($lang)
            ));
        } elseif ($user->type === User::ROLE_COACH) {
            $this->render('additional_coach', array(
                'lang' => $lang,
                'info' => $user->getInfo($lang)
            ));
        }
    }

    /**
     * Method for saving coach additional information
     */
    public function actionAdditional_Coach()
    {
        if ($this->request->isPostRequest && $this->request->isAjaxRequest) {

            $lang                   = $this->request->getPost('language');
            $phoneHome              = $this->request->getPost('phoneHome');
            $phoneMobile            = $this->request->getPost('phoneMobile');
            $skype                  = $this->request->getPost('skype');
            $acmnumber              = $this->request->getPost('ACMNumber');
            $instName               = $this->request->getPost('instName');
            $instNameShort          = $this->request->getPost('instNameShort');
            $instDivision           = $this->request->getPost('instDivision');
            $instPostEmailAddresses = $this->request->getPost('instPostEmailAddresses');

            $position      = $this->request->getPost('position');
            $officeAddress = $this->request->getPost('officeAddress');
            $phoneWork     = $this->request->getPost('phoneWork');
            $fax           = $this->request->getPost('fax');

            $user = \yii::app()->user->getInstance();

            $user->info->setAttributes(array(
                'lang'                   => $lang,
                'phoneHome'              => $phoneHome,
                'phoneMobile'            => $phoneMobile,
                'skype'                  => $skype,
                'ACMNumber'              => $acmnumber,
                'instName'               => $instName,
                'instNameShort'          => $instNameShort,
                'instDivision'           => $instDivision,
                'instPostEmailAddresses' => $instPostEmailAddresses,

                'position'               => $position,
                'officeAddress'          => $officeAddress,
                'phoneWork'              => $phoneWork,
                'fax'                    => $fax
            ), false);
            $user->info->save();

            // Render json
            $this->renderJson(array(
                'errors' => $user->info->hasErrors() ? $user->info->getErrors() : false
            ));

        } else {
            return $this->httpException(403);
        }
    }

    /**
     * Method for saving student additional information
     */
    public function actionAdditional_Student()
    {
        if ($this->request->isPostRequest && $this->request->isAjaxRequest) {

            $lang                   = $this->request->getPost('language');
            $phoneHome              = $this->request->getPost('phoneHome');
            $phoneMobile            = $this->request->getPost('phoneMobile');
            $skype                  = $this->request->getPost('skype');
            $acmnumber              = $this->request->getPost('ACMNumber');
            $instName               = $this->request->getPost('instName');
            $instNameShort          = $this->request->getPost('instNameShort');
            $instDivision           = $this->request->getPost('instDivision');
            $instPostEmailAddresses = $this->request->getPost('instPostEmailAddresses');

            $studyField        = $this->request->getPost('studyField');
            $speciality        = $this->request->getPost('speciality');
            $faculty           = $this->request->getPost('faculty');
            $group             = $this->request->getPost('group');
            $instAdmissionYear = $this->request->getPost('instAdmissionYear');
            $dateOfBirth       = $this->request->getPost('dateOfBirth');
            $document          = $this->request->getPost('document');

            $user = \yii::app()->user->getInstance();

            $user->info->setAttributes(array(
                'lang'                   => $lang,
                'phoneHome'              => $phoneHome,
                'phoneMobile'            => $phoneMobile,
                'skype'                  => $skype,
                'ACMNumber'              => $acmnumber,
                'instName'               => $instName,
                'instNameShort'          => $instNameShort,
                'instDivision'           => $instDivision,
                'instPostEmailAddresses' => $instPostEmailAddresses,

                'studyField'        => $studyField,
                'speciality'        => $speciality,
                'faculty'           => $faculty,
                'group'             => $group,
                'instAdmissionYear' => $instAdmissionYear,
                'dateOfBirth'       => $dateOfBirth,
                'document'          => $document,
            ), false);
            $user->info->save();

            // Render json
            $this->renderJson(array(
                'errors' => $user->info->hasErrors() ? $user->info->getErrors() : false
            ));

        } else {
            return $this->httpException(403);
        }
    }

}