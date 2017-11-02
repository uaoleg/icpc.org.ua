<?php

namespace frontend\controllers;

use \common\models\School;
use \common\models\User;
use \frontend\models\WebUser;
use \yii\helpers\Url;

class AuthController extends BaseController
{

    /**
     * Check recaptcha code
     *
     * @return bool|string
     */
    protected function _checkRecaptcha()
    {
        // Get params
        $response           = \yii::$app->request->post('recaptcha_response_field');
        $errorMessage       = \yii::t('app', 'The recaptcha code is incorrect.');
        $recaptchaIgnore    = (bool)\yii::$app->request->post('recaptchaIgnore', 0);

        // Return "true" if not production environment
        if ((\YII_ENV !== \YII_ENV_PROD) && ($recaptchaIgnore)) {
            return true;
        }

        // Check recaptcha
        try {

            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = [
                'secret'   => \yii::$app->params['recaptcha.privateKey'],
                'response' => $response,
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ];

            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                ]
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if (json_decode($result)->success) {
                return true;
            } else {
                return $errorMessage;
            }
        } catch (Exception $ex) {
            return $errorMessage;
        }
    }

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'login';

        // Set active main menu item
        $this->setNavActiveItem('main', '');
    }

    /**
     * Before action
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Take away loggedin users
        if ((!\yii::$app->user->isGuest) && ($this->action->id !== 'logout')) {
            return $this->redirect('/');
        }

        return true;
    }

    /**
     * Login page
     */
    public function actionLogin()
    {
        // Get params
        $email      = mb_strtolower(\yii::$app->request->post('email'));
        $password   = \yii::$app->request->post('password');

        // Login
        $error = '';
        $confirmation = null;
        if (\yii::$app->request->isPost) {
            $user = User::findOne(['email' => $email]);
            if (!$user || !$user->checkPassword($password)) {
                $error = \yii::t('app', 'Email or password is invalid');
            } elseif (!$user->isEmailConfirmed) {
                $error = \yii::t('app', 'E-mail is not confirmed');
                $confirmation = User\EmailConfirmation::findOne(['userId' => $user->id]);
            } else {
                \yii::$app->user->login($user);

                $userUk = User::findOne(\yii::$app->user->id);
                $userUk::$useLanguage = 'uk';
                $infoUk = $userUk->info;
                if (!$infoUk->validate()) {
                    \yii::$app->user->setState(WebUser::SESSION_INFO_NOT_FULL, true);
                    return $this->redirect(Url::toRoute(['/user/additional', 'lang' => 'uk']));
                }

                $userEn = User::findOne(\yii::$app->user->id);
                $userEn::$useLanguage = 'en';
                $infoEn = $userEn->info;
                if (!$infoEn->validate()) {
                    \yii::$app->user->setState(WebUser::SESSION_INFO_NOT_FULL, true);
                    return $this->redirect(Url::toRoute(['user/additional', 'lang' => 'en']));
                }


                \yii::$app->user->setState(WebUser::SESSION_INFO_NOT_FULL, false);
                return $this->redirect('/');
            }
        }

        // Render view
        return $this->render('login', array(
            'email'         => $email,
            'error'         => $error,
            'confirmation'  => $confirmation,
        ));
    }

    /**
     * Password reset page
     */
    public function actionPasswordReset()
    {
        // Render view
        return $this->render('password-reset');
    }

    /**
     * Password reset sent success page
     */
    public function actionPasswordResetSent()
    {
        // Render view
        return $this->render('password-reset-sent');
    }

    /**
     * Send email with password reset URL
     */
    public function actionPasswordResetSendEmail()
    {
        // Get params
        $email = \yii::$app->request->get('email');

        // Get user by email
        $userExists = (User::findOne(['email' => mb_strtolower($email)]) !== null);

        // Check recaptcha
        $recaptchaStatus = $this->_checkRecaptcha();

        // Form errors
        $errors = array();
        if (!$userExists) {
            $errors['email'] = \yii::t('app', 'We do not know such a email.');
        }
        if ($recaptchaStatus !== true) {
            $errors['recaptcha'] = $recaptchaStatus;
        }

        // Send password reset email
        if (count($errors) === 0) {

            // Get reset token
            User\PasswordReset::deleteAll(['email' => $email]);
            $resetToken = new User\PasswordReset();
            $resetToken->email = $email;
            $resetToken->save();

            // Send email
            $message = new \common\ext\Mail\MailMessage();
            $message
                ->addTo($email)
                ->setFrom(\yii::$app->params['emails']['noreply']['address'], \yii::$app->params['emails']['noreply']['name'])
                ->setSubject(\yii::t('app', 'Password reset'))
                ->setView('password-reset', array(
                    'link' => Url::toRoute(['/auth/password-reset-enter-new',  'token' => $resetToken->id], true),
                ));
            \yii::$app->mail->send($message);
        }

        // Render json
        return $this->renderJson(array(
            'errors' => count($errors) ? $errors : false,
        ));
    }

    /**
     * Enter new password page
     */
    public function actionPasswordResetEnterNew()
    {
        // Get params
        $tokenId = \yii::$app->request->get('token');

        // Get token record
        $token = User\PasswordReset::findOne($tokenId);

        // Render view
        if (($token === null) || (!$token->isValid)) {
            return $this->render('password-reset-token-error');
        } else {
            return $this->render('password-reset-enter-new', array(
                'token' => $token,
            ));
        }
    }

    /**
     * Set new password
     */
    public function actionPasswordResetSetNew()
    {
        // Get params
        $tokenId        = \yii::$app->request->get('token');
        $password       = \yii::$app->request->get('password');
        $passwordRepeat = \yii::$app->request->get('passwordRepeat');

        // Get and check token
        $token = User\PasswordReset::findOne($tokenId);
        if (($token === null) || (!$token->isValid)) {
            return;
        }

        // Get user
        $user = User::findOne(['email' => $token->email]);

        // Set new password and login user
        $user->setPassword($password, $passwordRepeat);

        // Save to DB
        if (!$user->hasErrors()) {

            // Save new password, no validation
            $user->save(false);

            // Authenticate user
            $identity = new \web\ext\UserIdentity($token->email, $password);
            $identity->authenticate();
            \yii::$app->user->login($identity);

            // Delete token
            $token->delete();
        }

        // Render json
        return $this->renderJson(array(
            'errors' => $user->hasErrors() ? $user->getErrors() : false,
        ));
    }

    /**
     * Logout
     */
    public function actionLogout()
    {
        \yii::$app->user->logout();
        return $this->redirect('/');
    }

    /**
     * Confirm email page
     */
    public function actionEmailConfirm()
    {
        // Get params
        $token = \yii::$app->request->get('token');

        // Confirm email
        try {
            $emailConfirmation = User\EmailConfirmation::findOne($token);
        } catch (\Exception $e) {
            $success = false;
        }
        if (isset($emailConfirmation)) {
            $user = User::findOne($emailConfirmation->userId);
            $user->isEmailConfirmed = true;
            $user->save();
            $success = true;
        } else {
            $success = false;
        }

        // Render view
        return $this->render('email-confirm', array('success' => $success));
    }

    /**
     * Signup page
     */
    public function actionSignup()
    {
        // Get params
        $firstNameUk    = \yii::$app->request->post('firstNameUk');
        $middleNameUk   = \yii::$app->request->post('middleNameUk');
        $lastNameUk     = \yii::$app->request->post('lastNameUk');
        $email          = mb_strtolower(\yii::$app->request->post('email'));
        $password       = \yii::$app->request->post('password');
        $passwordRepeat = \yii::$app->request->post('passwordRepeat');
        $type           = \yii::$app->request->post('type');
        $coordinator    = \yii::$app->request->post('coordinator');
        $schoolId       = \yii::$app->request->post('schoolId');
        $rulesAgree     = (bool)\yii::$app->request->post('rulesAgree');

        // Hidden params (might be imported from icpc.baylor.edu)
        $firstNameEn = \yii::$app->request->post('firstNameEn');
        $lastNameEn  = \yii::$app->request->post('lastNameEn');
        $acmId       = \yii::$app->request->post('acmId');
        $phoneHome   = \yii::$app->request->post('phoneHome');
        $phoneMobile = \yii::$app->request->post('phoneMobile');
        $tshirtSize   = \yii::$app->request->post('shirtSize');

        // Set attributes
        $user = new User();
        $user->setAttributes(array(
            'firstNameUk'   => $firstNameUk,
            'middleNameUk'  => $middleNameUk,
            'lastNameUk'    => $lastNameUk,
            'firstNameEn'   => $firstNameEn,
            'lastNameEn'    => $lastNameEn,
            'email'         => $email,
            'type'          => $type,
            'coordinator'   => $coordinator,
            'schoolId'      => $schoolId,
        ), false);

        // Register a new user
        if (\yii::$app->request->isPost) {

            // Validate user date
            $user->validate();
            $user->setPassword($password, $passwordRepeat);

            // Check rules to be accepted
            if (!$rulesAgree) {
                $user->addError('rulesAgree', \yii::t('app', 'Please, read and accept service rules'));
            }

            // Check recaptcha in the very end
            if (!$user->hasErrors()) {
                $recaptchaStatus = $this->_checkRecaptcha();
                if ($recaptchaStatus !== true) {
                    $user->addError('recaptcha', $recaptchaStatus);
                }
            }

            // If no errors, than create and auth user
            if (!$user->hasErrors()) {

                // Save user
                $user->save();

                // Assign student role
                if ($user->type === User::ROLE_STUDENT) {
                    $user->isApprovedStudent = true;
                }

                // Create an email confirmation record
                $emailConfirmation = new User\EmailConfirmation();
                $emailConfirmation->userId = $user->id;
                $emailConfirmation->save();

                // Send email
                $message = new \common\ext\Mail\MailMessage();
                $message
                    ->addTo($user->email)
                    ->setFrom(\yii::$app->params['emails']['noreply']['address'], \yii::$app->params['emails']['noreply']['name'])
                    ->setSubject(\yii::t('app', '{app} Email confirmation', array('app' => \yii::$app->name)))
                    ->setView('email-confirmation', array(
                        'link' => Url::toRoute(['/auth/email-confirm', 'token' => $emailConfirmation->id], true),
                    ));
                \yii::$app->mail->send($message);

                // Save user settings
                $settings = $user->settings;
                $settings->setAttributes(array(
                    'geo'   => $this->getGeo(),
                    'year'  => $this->getYear(),
                    'lang'  => \yii::$app->request->cookies->getValue('language'),
                ), false);
                $settings->save();

                // Save user additional info
                $info = $user->info;
                $info->setAttributes(array(
                    'acmNumber'   => $acmId,
                    'phoneHome'   => $phoneHome,
                    'phoneMobile' => $phoneMobile,
                    'tShirtSize'  => $tshirtSize,
                ), false);
                $info->save();


                // Authenticate user
                $identity = new \web\ext\UserIdentity($email, $password);
                $identity->authenticate();
                \yii::$app->user->login($identity);
            }

            // Render json
            return $this->renderJson(array(
                'errors'    => $user->hasErrors() ? $user->getErrors() : false,
                'url'       => $user->hasErrors() ? '' : Url::toRoute(['signedup', 'id' => $emailConfirmation->id]),
            ));
        }

        // Render page
        else {

            // Render view
            return $this->render('signup', array(
                'user'              => $user,
                'password'          => $password,
                'passwordRepeat'    => $passwordRepeat,
                'rulesAgree'        => $rulesAgree,
            ));
        }
    }

    /**
     * After signup page
     */
    public function actionSignedUp()
    {
        // Get params
        $confirmationId = \yii::$app->request->get('id');

        if ($confirmationId !== null) {
            $confirmation = User\EmailConfirmation::findOne($confirmationId);
            if ($confirmation !== null) {
                return $this->render('signedup', array(
                    'confirmation' => $confirmation,
                ));
            } else {
                $this->httpException(404);
            }
        } else {
            return $this->redirect('/');
        }
    }

    /**
     * Resend email confirmation action
     */
    public function actionResendEmailConfirmation()
    {
        // Get params
        $confirmationId = \yii::$app->request->get('confirmationId');

        // Get confirmation
        $confirmation = User\EmailConfirmation::findOne($confirmationId);
        if ($confirmation === null) {
            $this->httpException(404);
        }

        // Check confirmation sent time
        if ($confirmation->dateConfirmed->sec > strtotime("-1 day")) {
            $this->httpException(403, \yii::t('app', 'E-mail confirmation request can be sent no more than 1 time per day.'));
        }

        // Get user
        $user = User::findOne($confirmation->userId);
        if ($user === null) {
            $this->httpException(404);
        }

        // Send email
        $message = new \common\ext\Mail\MailMessage();
        $message
            ->addTo($user->email)
            ->setFrom(\yii::$app->params['emails']['noreply']['address'], \yii::$app->params['emails']['noreply']['name'])
            ->setSubject(\yii::t('app', '{app} Email confirmation', array('app' => \yii::$app->name)))
            ->setView('email-confirmation', array(
                'link' => Url::toRoute(['/auth/email-confirm', 'token' => $confirmation->id], true),
            ));
        \yii::$app->mail->send($message);

        //update request date
        $confirmation->dateConfirmed = false;
        $confirmation->save();
    }

    /**
     * Action to get the list of schools for signup
     */
    public function actionSchools()
    {
        // Get params
        $query = \yii::$app->request->post('q');

        // Define full name field by core language
        $lang = \yii::$app->user->languageCore;
        $fullNameField = 'fullName' . ucfirst($lang);

        // Get schools
        $schools = School::find()
            ->andWhere(['LIKE', $fullNameField, $query])
            ->all()
        ;

        // Create json list of schools
        $schoolsJson = array();
        foreach ($schools as $school) {
            $schoolsJson[] = array(
                'id'    => $school->id,
                'text'  => $school->$fullNameField,
            );
        }

        // Render json
        return $this->renderJson(['schools' => $schoolsJson]);
    }
}
