<?php

namespace web\controllers;

use \common\models\School;
use \common\models\Team;
use \common\models\User;
use \web\ext\WebUser;

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

            // Save changes
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
                'user'              => $user,
                'coordinatorLabel'  => $coordinatorLabel,
                'schools'           => $schools,
            ));
        }
    }

    /**
     * Upload avatar
     */
    public function actionPhoto()
    {
        // Get params
        $imageId = mb_substr($this->request->getParam('id'), 0, 24);

        // Get document
        $image = User\Photo::model()->findByPk(new \MongoId($imageId));
        if ($image === null) {
            $this->httpException(404);
        }

        // Send headers
        header('Content-type: image/jpeg');
        header('Cache-Control: public, max-age=' . SECONDS_IN_YEAR . ', pre-check=' . SECONDS_IN_YEAR);
        header('Pragma: public');
        header('Expires: ' . gmdate(DATE_RFC1123, time() + SECONDS_IN_YEAR));
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            header('HTTP/1.1 304 Not Modified');
            \yii::app()->end();
        }

        // Send content
        echo $image->file->getBytes();
    }

    /**
     * Page with additional information
     */
    public function actionAdditional()
    {
        // Check access
        if (\yii::app()->user->isGuest) {
            return $this->redirect(\yii::app()->user->loginUrl);
        }

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

        $info = $user->setUseLanguage($lang)->info;
        $validators = $info->getValidators('tShirtSize');
        $sizes = array();
        foreach ($validators as $validator)
        {
            if ($validator instanceof \CRangeValidator)
            {
                $sizes = $validator->range;
                break;
            }
        }

        // Render view
        $this->render($view, array(
            'lang'  => $lang,
            'info'  => $user->setUseLanguage($lang)->info,
            'sizes' => $sizes
        ));
    }

    /**
     * Change password request
     */
    public function actionPasswordChange()
    {
        // Update password
        if ($this->request->isPostRequest) {

            // Get params
            $currentPassword = $this->request->getPost('currentPassword');
            $password        = $this->request->getPost('password');
            $passwordRepeat  = $this->request->getPost('passwordRepeat');

            // Set new password
            $user = \yii::app()->user->getInstance();
            if ($user->checkPassword($currentPassword)) {
                $user->setPassword($password, $passwordRepeat);
            } else {
                $user->addError('currentPassword', \yii::t('app', '{attr} is incorrect', array(
                    '{attr}' => $user->getAttributeLabel('password'),
                )));
            }
            if (!$user->hasErrors()) {
                $user->save(false);
                \yii::app()->user->setFlash('passwordChangeSuccess', true);
            }

            // Render json
            $this->renderJson(array(
                'errors' => $user->hasErrors() ? $user->getErrors() : false,
            ));

        }
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
        $dateOfBirth              = $this->request->getPost('dateOfBirth');
        $skype                    = $this->request->getPost('skype');
        $tShirtSize               = $this->request->getPost('tShirtSize');
        $acmnumber                = $this->request->getPost('acmNumber');
        $schoolName               = $this->request->getPost('schoolName');
        $schoolNameShort          = $this->request->getPost('schoolNameShort');
        $schoolPostEmailAddresses = $this->request->getPost('schoolPostEmailAddresses');

        $position      = $this->request->getPost('position');
        $officeAddress = $this->request->getPost('officeAddress');
        $phoneWork     = $this->request->getPost('phoneWork');
        $fax           = $this->request->getPost('fax');

        // Save additional info
        $info = \yii::app()->user->getInstance()->setUseLanguage($lang)->info;
        $info->setAttributes(array(
            'lang'                     => $lang,
            'phoneHome'                => $phoneHome,
            'phoneMobile'              => $phoneMobile,
            'dateOfBirth'              => $dateOfBirth,
            'skype'                    => $skype,
            'tShirtSize'               => $tShirtSize,
            'acmNumber'                => $acmnumber,
            'schoolName'               => $schoolName,
            'schoolNameShort'          => $schoolNameShort,
            'schoolPostEmailAddresses' => $schoolPostEmailAddresses,

            'position'      => $position,
            'officeAddress' => $officeAddress,
            'phoneWork'     => $phoneWork,
            'fax'           => $fax
        ), false);
        $info->scenario = User\InfoCoach::SC_ALLOW_EMPTY;
        $info->save();
        \yii::app()->user->setState(WebUser::SESSION_INFO_NOT_FULL, $info->hasErrors());

        $info->scenario = '';
        $info->validate();

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
        $dateOfBirth              = $this->request->getPost('dateOfBirth');
        $skype                    = $this->request->getPost('skype');
        $tShirtSize               = $this->request->getPost('tShirtSize');
        $acmnumber                = $this->request->getPost('acmNumber');
        $schoolName               = $this->request->getPost('schoolName');
        $schoolNameShort          = $this->request->getPost('schoolNameShort');
        $schoolPostEmailAddresses = $this->request->getPost('schoolPostEmailAddresses');

        $studyField          = $this->request->getPost('studyField');
        $speciality          = $this->request->getPost('speciality');
        $faculty             = $this->request->getPost('faculty');
        $group               = $this->request->getPost('group');
        $schoolAdmissionYear = $this->request->getPost('schoolAdmissionYear');
        $course              = $this->request->getPost('course');
        $document            = $this->request->getPost('document');

        // Save additional info
        $info = \yii::app()->user->getInstance()->setUseLanguage($lang)->info;
        $info->setAttributes(array(
            'lang'                     => $lang,
            'phoneHome'                => $phoneHome,
            'phoneMobile'              => $phoneMobile,
            'dateOfBirth'              => $dateOfBirth,
            'skype'                    => $skype,
            'tShirtSize'               => $tShirtSize,
            'acmNumber'                => $acmnumber,
            'schoolName'               => $schoolName,
            'schoolNameShort'          => $schoolNameShort,
            'schoolPostEmailAddresses' => $schoolPostEmailAddresses,

            'studyField'          => $studyField,
            'speciality'          => $speciality,
            'faculty'             => $faculty,
            'group'               => $group,
            'schoolAdmissionYear' => $schoolAdmissionYear,
            'course'              => $course,
            'document'            => $document,
        ), false);
        $info->scenario = User\InfoStudent::SC_ALLOW_EMPTY;
        $info->save();
        \yii::app()->user->setState(WebUser::SESSION_INFO_NOT_FULL, $info->hasErrors());

        $info->scenario = '';
        $info->validate();

        // Render json
        $this->renderJson(array(
            'errors' => $info->hasErrors() ? $info->getErrors() : false
        ));
    }

    /**
     * Public user's profile
     */
    public function actionView()
    {
        // Get params
        $userId = $this->request->getParam('id');

        // Get user
        $user = User::model()->findByPk(new \MongoId($userId));
        if ($user === null) {
            $this->httpException(404);
        }

        // Get teams
        $criteria = new \EMongoCriteria();
        $criteria->addCond('memberIds', 'in', (array)$userId);
        $criteria->sort('year', \EMongoCriteria::SORT_DESC);
        $teams = Team::model()->findAll($criteria);

        // Full profile view attributes
        if (\yii::app()->user->checkAccess(\common\components\Rbac::OP_STUDENT_VIEW_FULL, array('user' => $user))) {
            $fullViewAttrs = $user->info->getAttributes();
            unset($fullViewAttrs['_id']);
            unset($fullViewAttrs['userId']);
            unset($fullViewAttrs['lang']);
        } else {
            $fullViewAttrs = array();
        }

        // Render view
        $this->render('view', array(
            'user'          => $user,
            'teams'         => $teams,
            'fullViewAttrs' => $fullViewAttrs
        ));
    }

    /**
     * Action that parses info from icpc.baylor.edu
     *
     * @throws \CHttpException
     */
    public function actionBaylor()
    {
        if ($this->request->isPostRequest && $this->request->isAjaxRequest) {

            $email = \yii::app()->request->getPost('email');
            $password = \yii::app()->request->getPost('password');

            \yii::app()->user->setState('baylor_email', $email);

            $response = \yii::app()->baylor->import($email, $password);

            $this->renderJson($response);
        } else {
            $this->httpException(404);
        }
    }

}
