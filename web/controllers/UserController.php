<?php

namespace web\controllers;

use \common\models\School;
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
        // Check access
        if (\yii::app()->user->isGuest) {
            return $this->redirect(\yii::app()->user->loginUrl);
        }

        // Set active user submenu item
        $this->setNavActiveItem('user', 'me');

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
     * Page with additional information
     */
    public function actionAdditional()
    {
        // Get params
        $lang = $this->request->getParam('lang');
        $user = \yii::app()->user->getInstance();

        // Set active user submenu item
        $this->setNavActiveItem('user', 'additional' . $lang);

        // Get view name
        if ($user->type === User::ROLE_STUDENT) {
            $view = 'additionalStudent';
        } elseif ($user->type === User::ROLE_COACH) {
            $view = 'additionalCoach';
        } else {
            $view = 'additionalEmpty';
        }

        // Render view
        $this->render($view, array(
            'lang' => $lang,
            'info' => $user->getInfo($lang)
        ));
    }

    /**
     * Save coach additional information
     */
    public function actionAdditionalCoachSave()
    {
        // Get params
        $lang                     = $this->request->getPost('language');
        $phoneHome                = $this->request->getPost('phoneHome');
        $phoneMobile              = $this->request->getPost('phoneMobile');
        $skype                    = $this->request->getPost('skype');
        $acmnumber                = $this->request->getPost('acmNumber');
        $schoolName               = $this->request->getPost('schoolName');
        $schoolNameShort          = $this->request->getPost('schoolNameShort');
        $schoolDivision           = $this->request->getPost('schoolDivision');
        $schoolPostEmailAddresses = $this->request->getPost('schoolPostEmailAddresses');

        $position      = $this->request->getPost('position');
        $officeAddress = $this->request->getPost('officeAddress');
        $phoneWork     = $this->request->getPost('phoneWork');
        $fax           = $this->request->getPost('fax');

        // Save additional info
        $info = \yii::app()->user->getInstance()->getInfo($lang);
        $info->setAttributes(array(
            'lang'                     => $lang,
            'phoneHome'                => $phoneHome,
            'phoneMobile'              => $phoneMobile,
            'skype'                    => $skype,
            'acmNumber'                => $acmnumber,
            'schoolName'               => $schoolName,
            'schoolNameShort'          => $schoolNameShort,
            'schoolDivision'           => $schoolDivision,
            'schoolPostEmailAddresses' => $schoolPostEmailAddresses,

            'position'      => $position,
            'officeAddress' => $officeAddress,
            'phoneWork'     => $phoneWork,
            'fax'           => $fax
        ), false);
        $info->save();

        // Render json
        $this->renderJson(array(
            'errors' => $info->hasErrors() ? $info->getErrors() : false
        ));
    }

    /**
     * Save student additional information
     */
    public function actionAdditionalStudentSave()
    {
        // Get params
        $lang                     = $this->request->getPost('language');
        $phoneHome                = $this->request->getPost('phoneHome');
        $phoneMobile              = $this->request->getPost('phoneMobile');
        $skype                    = $this->request->getPost('skype');
        $acmnumber                = $this->request->getPost('acmNumber');
        $schoolName               = $this->request->getPost('schoolName');
        $schoolNameShort          = $this->request->getPost('schoolNameShort');
        $schoolDivision           = $this->request->getPost('schoolDivision');
        $schoolPostEmailAddresses = $this->request->getPost('schoolPostEmailAddresses');

        $studyField          = $this->request->getPost('studyField');
        $speciality          = $this->request->getPost('speciality');
        $faculty             = $this->request->getPost('faculty');
        $group               = $this->request->getPost('group');
        $schoolAdmissionYear = $this->request->getPost('schoolAdmissionYear');
        $dateOfBirth         = $this->request->getPost('dateOfBirth');
        $document            = $this->request->getPost('document');

        // Save additional info
        $info = \yii::app()->user->getInstance()->getInfo($lang);
        $info->setAttributes(array(
            'lang'                     => $lang,
            'phoneHome'                => $phoneHome,
            'phoneMobile'              => $phoneMobile,
            'skype'                    => $skype,
            'acmNumber'                => $acmnumber,
            'schoolName'               => $schoolName,
            'schoolNameShort'          => $schoolNameShort,
            'schoolDivision'           => $schoolDivision,
            'schoolPostEmailAddresses' => $schoolPostEmailAddresses,

            'studyField'          => $studyField,
            'speciality'          => $speciality,
            'faculty'             => $faculty,
            'group'               => $group,
            'schoolAdmissionYear' => $schoolAdmissionYear,
            'dateOfBirth'         => $dateOfBirth,
            'document'            => $document,
        ), false);
        $info->save();

        // Render json
        $this->renderJson(array(
            'errors' => $info->hasErrors() ? $info->getErrors() : false
        ));
    }

}