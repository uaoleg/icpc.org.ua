<?php

namespace web\controllers;

use \common\models\User;

class AuthController extends \web\ext\Controller
{

    /**
     * Check recaptcha code
     *
     * @return bool|string
     */
	protected function _checkRecaptcha()
	{
        $challengeField = $this->request->getParam('recaptcha_challenge_field');
        $responseField  = $this->request->getParam('recaptcha_response_field');
        $errorMessage   = \yii::t('app', 'The recaptcha code is incorrect.');

        if (($responseField === null) || ($challengeField === null)) {
            return $errorMessage;
        }

        \yii::import('common.lib.recaptcha.reCAPTCHA.recaptchalib', true);
	    $response = recaptcha_check_answer(
            \yii::app()->params['recaptcha']['privateKey'],
            \yii::app()->request->userHostAddress,
            $challengeField,
            $responseField
        );
		if ($response->is_valid) {
            return true;
        } else {
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
     *
     * @param \CAction $action
     * @return bool
     */
    protected function beforeAction($action)
    {
        if (!parent::beforeAction($action)) return false;

        // Take away loggedin users
        if ((!\yii::app()->user->isGuest) && ($this->action->id !== 'logout')) {
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
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');

        // Login
        $error = '';
        if ($this->request->isPostRequest) {
            $identity = new \web\ext\UserIdentity($email, $password);
            if ($identity->authenticate()) {
                \yii::app()->user->login($identity);
                return $this->redirect('/');
            } else {
                $error = $identity->errorMessage;
            }
        }

        // Render view
        $this->render('login', array(
            'email' => $email,
            'error' => $error,
        ));
    }

    /**
     * Reset password
     */
    public function actionPasswordReset()
    {
        // Get params
        $email          = $this->request->getParam('email');
        $tokenId        = $this->request->getParam('token');
        $password       = $this->request->getParam('password');
        $passwordRepeat = $this->request->getParam('passwordRepeat');
        $passwordSetNew = (bool)$this->request->getParam('passwordSetNew', 0);   
        
        if ($this->request->isPostRequest || $tokenId) {
            if (($email !== null) && (empty($tokenId))) {
                $this->_emailResetPwd($email);
            } elseif ((!empty($tokenId)) && (!$passwordSetNew)) {
                $this->_renderSetNewPwdForm($tokenId);
            } elseif ((!empty($tokenId)) && ($passwordSetNew)) {
                $this->_setNewPwd($tokenId, $password, $passwordRepeat);
            }
        } else {
            $this->render('passwordReset');
        }
    }
    
    /**
     * Password reset sent notification
     */
    public function actionPasswordResetSent()
    {
        // Render view
        $this->render('passwordResetSent');
    }

    /**
     * Logout
     */
    public function actionLogout()
    {
        \yii::app()->user->logout();
        return $this->redirect('/');
    }

    /**
     * Signup page
     */
    public function actionSignup()
    {
        // Get params
        $firstName      = $this->request->getPost('firstName');
        $lastName       = $this->request->getPost('lastName');
        $email          = $this->request->getPost('email');
        $password       = $this->request->getPost('password');
        $passwordRepeat = $this->request->getPost('passwordRepeat');
        $type           = $this->request->getPost('type');
        $coordinator    = $this->request->getPost('coordinator');
        $rulesAgree     = (bool)$this->request->getPost('rulesAgree');

        // Register a new user
        if ($this->request->isPostRequest) {

            // Validate user date
            $user = new User();
            $user->setAttributes(array(
                'firstName'     => $firstName,
                'lastName'      => $lastName,
                'email'         => $email,
                'type'          => $type,
                'coordinator'   => $coordinator,
            ), false);
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
                $user->save();
                $identity = new \web\ext\UserIdentity($email, $password);
                $identity->authenticate();
                \yii::app()->user->login($identity);
            }

            // Render json
            $this->renderJson(array(
                'errors' => $user->hasErrors() ? $user->getErrors() : false,
            ));
        }

        // Render view
        else {
            $this->render('signup', array(
                'firstName'         => $firstName,
                'lastName'          => $lastName,
                'email'             => $email,
                'password'          => $password,
                'passwordRepeat'    => $passwordRepeat,
                'rulesAgree'        => $rulesAgree,
            ));
        }
    }

    protected function _emailResetPwd($email)
    {
        // Get user by email
        $userExists = (User::model()->countByAttributes(array(
            'email' => mb_strtolower($email),
        )) > 0);

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

            $criteriaResetToken = new \EMongoCriteria();
            $criteriaResetToken->addCond('email', '==', $email);
            User\PasswordReset::model()->deleteAll($criteriaResetToken);
            $resetToken = new User\PasswordReset();
            $resetToken->email = $email;
            $resetToken->save();

            $this->getHelper('mail')->sendMail(
                array(
                    'email' => $email,
                    'subject' => \yii::t('app', 'Password reset'),
                    'view' => 'passwordReset',
                    'params' => array(
                        'link' => $this->createAbsoluteUrl('/auth/passwordReset', array(
                            'token' => (string)$resetToken->_id,
                        )),
                    ),
                )
            );
        }
        $this->renderJson(array(
            'errors' => count($errors) ? $errors : false,
        ));        
    }
    
    protected function _renderSetNewPwdForm($tokenId)
    {
        $token = User\PasswordReset::model()->findByPk(new \MongoId($tokenId));
        if (($token === null) || (!$token->isValid)) {
            $this->render('passwordResetTokenError');
        } else {
            $this->render('passwordResetToken', array(
                'token' => $token,
            ));
        }        
    }
    
    protected function _setNewPwd($tokenId, $password, $passwordRepeat)
    {
        $token = User\PasswordReset::model()->findByPk(new \MongoId($tokenId));
        $user = User::model()->findByAttributes(array(
            'email' => $token->email,
        ));
        $this->getHelper('user')->resetPwdAndLogin($user, $token, $password, $passwordRepeat);
        $this->renderJson(array(
            'errors' => $user->hasErrors() ? $user->getErrors() : false,
        ));        
    }
}
