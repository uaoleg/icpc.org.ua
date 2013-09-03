<?php

namespace web\controllers;

use \common\models\User;

class AuthController extends \web\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'login';
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
                \yii::app()->user->allowAutoLogin = true;
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

        // Register a new teacher
        $errors = array();
        if ($this->request->isPostRequest) {
            $user = new User();
            $user->setAttributes(array(
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'email'     => $email,
            ), false);
            $user->validate();
            $user->setPassword($password, $passwordRepeat);
            if (!$user->hasErrors()) {
                $user->save();
                $identity = new \web\ext\UserIdentity($email, $password);
                $identity->authenticate();
                \yii::app()->user->allowAutoLogin = true;
                \yii::app()->user->login($identity);
                return $this->redirect('/');
            } else {
                $errors = $user->getErrors();
            }
        }

        // Render view
        $this->render('signup', array(
            'firstName'         => $firstName,
            'lastName'          => $lastName,
            'email'             => $email,
            'password'          => $password,
            'passwordRepeat'    => $passwordRepeat,
            'errors'            => $errors,
        ));
    }

}