<?php

namespace frontend\controllers;

use \common\models\School;
use \common\models\Team;
use \common\models\User;
use \frontend\models\WebUser;

class UserController extends BaseController
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
        if (\yii::$app->user->isGuest) {
            return $this->redirect(\yii::$app->user->loginUrl);
        }

        // Set active user submenu item
        $this->setNavActiveItem('user', 'me');

        // Get params
        $firstNameUk       = \yii::$app->request->post('firstNameUk');
        $middleNameUk      = \yii::$app->request->post('middleNameUk');
        $lastNameUk        = \yii::$app->request->post('lastNameUk');
        $firstNameEn       = \yii::$app->request->post('firstNameEn');
        $middleNameEn      = \yii::$app->request->post('middleNameEn');
        $lastNameEn        = \yii::$app->request->post('lastNameEn');
        $schoolId          = \yii::$app->request->post('schoolId');
        $type              = \yii::$app->request->post('type');
        $coordinator       = \yii::$app->request->post('coordinator');

        // Get logged in user
        $user = \yii::$app->user->identity;

        // Update user data
        if (\yii::$app->request->isPost) {

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
            return $this->renderJson(array(
                'errors' => $user->hasErrors() ? $user->getErrors() : false
            ));
        }

        // Show form
        else {

            // Get list of schools
            $schools = School::find()
                ->orderBy('fullNameUk')
                ->all()
            ;

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
            return $this->render('me', array(
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
        $imageId = mb_substr(\yii::$app->request->get('id'), 0, 24);

        // Get document
        $image = User\Photo::findOne($imageId);
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
            \yii::$app->end();
        }

        // Send content
        return $image->content;
    }

    /**
     * Page with additional information
     */
    public function actionAdditional()
    {
        // Check access
        if (\yii::$app->user->isGuest) {
            return $this->redirect(\yii::$app->user->loginUrl);
        }

        // Get params
        $lang = \yii::$app->request->get('lang');
        User::$useLanguage = $lang;
        $user = \yii::$app->user->identity;

        // Set active user submenu item
        $this->setNavActiveItem('user', 'additional' . $lang);

        // Get view name
        if ($user->type === User::ROLE_STUDENT) {
            $view = 'additional-student';
        } elseif ($user->type === User::ROLE_COACH) {
            $view = 'additional-coach';
        } else {
            $view = 'additional-empty';
        }

        $validators = $user->info->getValidators('tShirtSize');
        $sizes = array();
        foreach ($validators as $validator) {
            if ($validator instanceof \yii\validators\RangeValidator) {
                $sizes = $validator->range;
                break;
            }
        }

        // Render view
        return $this->render($view, array(
            'lang'  => $lang,
            'info'  => $user->info,
            'sizes' => $sizes
        ));
    }

    /**
     * Change password request
     */
    public function actionPasswordChange()
    {
        // Update password
        if (\yii::$app->request->isPost) {

            // Get params
            $currentPassword = \yii::$app->request->post('currentPassword');
            $password        = \yii::$app->request->post('password');
            $passwordRepeat  = \yii::$app->request->post('passwordRepeat');

            // Set new password
            $user = \yii::$app->user->identity;
            if ($user->checkPassword($currentPassword)) {
                $user->setPassword($password, $passwordRepeat);
            } else {
                $user->addError('currentPassword', \yii::t('app', '{attr} is incorrect', [
                    'attr' => $user->getAttributeLabel('password'),
                ]));
            }
            if (!$user->hasErrors()) {
                $user->save(false);
                \yii::$app->user->setState('passwordChangeSuccess', true);
            }

            // Render json
            return $this->renderJson(array(
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
        $lang                     = \yii::$app->request->post('language');
        $phoneHome                = \yii::$app->request->post('phoneHome');
        $phoneMobile              = \yii::$app->request->post('phoneMobile');
        $dateOfBirth              = \yii::$app->request->post('dateOfBirth');
        $skype                    = \yii::$app->request->post('skype');
        $tShirtSize               = \yii::$app->request->post('tShirtSize');
        $acmnumber                = \yii::$app->request->post('acmNumber');
        $schoolName               = \yii::$app->request->post('schoolName');
        $schoolNameShort          = \yii::$app->request->post('schoolNameShort');
        $schoolPostEmailAddresses = \yii::$app->request->post('schoolPostEmailAddresses');
        User::$useLanguage        = $lang;

        $position      = \yii::$app->request->post('position');
        $officeAddress = \yii::$app->request->post('officeAddress');
        $phoneWork     = \yii::$app->request->post('phoneWork');
        $fax           = \yii::$app->request->post('fax');

        // Save additional info
        $info = \yii::$app->user->identity->info;
        $info->setAttributes([
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
        ], false);
        $info->scenario = User\InfoCoach::SC_ALLOW_EMPTY;
        $info->save();
        \yii::$app->user->setState(WebUser::SESSION_INFO_NOT_FULL, $info->hasErrors());

        $info->scenario = User\InfoCoach::SCENARIO_DEFAULT;
        $info->validate();

        // Render json
        return $this->renderJson(array(
            'errors' => $info->hasErrors() ? $info->getErrors() : false
        ));
    }

    /**
     * Save student additional information
     */
    public function actionAdditionalStudentSave()
    {
        // Get params
        $lang                     = \yii::$app->request->post('language');
        $phoneHome                = \yii::$app->request->post('phoneHome');
        $phoneMobile              = \yii::$app->request->post('phoneMobile');
        $dateOfBirth              = \yii::$app->request->post('dateOfBirth');
        $skype                    = \yii::$app->request->post('skype');
        $tShirtSize               = \yii::$app->request->post('tShirtSize');
        $acmnumber                = \yii::$app->request->post('acmNumber');
        $schoolName               = \yii::$app->request->post('schoolName');
        $schoolNameShort          = \yii::$app->request->post('schoolNameShort');
        $schoolPostEmailAddresses = \yii::$app->request->post('schoolPostEmailAddresses');
        User::$useLanguage        = $lang;

        $studyField          = \yii::$app->request->post('studyField');
        $speciality          = \yii::$app->request->post('speciality');
        $faculty             = \yii::$app->request->post('faculty');
        $group               = \yii::$app->request->post('group');
        $schoolAdmissionYear = \yii::$app->request->post('schoolAdmissionYear');
        $course              = \yii::$app->request->post('course');
        $document            = \yii::$app->request->post('document');

        // Save additional info
        $info = \yii::$app->user->identity->info;
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
        \yii::$app->user->setState(WebUser::SESSION_INFO_NOT_FULL, $info->hasErrors());

        $info->scenario = User\InfoStudent::SCENARIO_DEFAULT;
        $info->validate();

        // Render json
        return $this->renderJson(array(
            'errors' => $info->hasErrors() ? $info->getErrors() : false
        ));
    }

    /**
     * Public user's profile
     */
    public function actionView()
    {
        // Get params
        $userId = \yii::$app->request->get('id');

        // Get user
        $user = User::findOne($userId);
        if ($user === null) {
            $this->httpException(404);
        }

        // Get teams
        $teams = Team::find()
            ->alias('team')
            ->innerJoin(['member' => Team\Member::tableName()], 'member.teamId = team.id')
            ->andWhere(['member.userId' => $user->id])
            ->orderBy('year DESC')
            ->all()
        ;

        // Full profile view attributes
        if (\yii::$app->user->can(\common\components\Rbac::OP_STUDENT_VIEW_FULL, array('user' => $user))) {
            $fullViewAttrs = $user->info->getAttributes();
            unset($fullViewAttrs['_id']);
            unset($fullViewAttrs['userId']);
            unset($fullViewAttrs['lang']);
        } else {
            $fullViewAttrs = array();
        }

        // Render view
        return $this->render('view', array(
            'user'          => $user,
            'teams'         => $teams,
            'fullViewAttrs' => $fullViewAttrs
        ));
    }

    /**
     * Action that parses info from icpc.baylor.edu
     * @throws \yii\web\HttpException
     */
    public function actionBaylor()
    {
        if (\yii::$app->request->isPost && \yii::$app->request->isAjax) {

            $email = \yii::$app->request->post('email');
            $password = \yii::$app->request->post('password');

            \yii::$app->user->setState('baylor_email', $email);

            $response = \yii::$app->baylor->import($email, $password);

            return $this->renderJson($response);
        } else {
            $this->httpException(404);
        }
    }

    /**
     * Request approve status for coach or coordinator
     */
    public function actionApprovalRequest()
    {
        $request = new User\ApprovalRequest();
        $request->userId = \yii::$app->user->id;
        $request->role = \yii::$app->request->get('role');
        $request->save();
    }

}
