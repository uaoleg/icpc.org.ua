<?php

namespace web\ext;

use \common\models\User;

class UserIdentity extends \CUserIdentity
{

    /**
     * User ID
     * @var int
     */
    protected $_id;

    /**
     * Get user
     *
     * @return User
     */
    protected function _getUser()
    {
        if ($this->username) {
            $criteria = new \EMongoCriteria();
            $criteria->addCond('email', '==', mb_strtolower($this->username));
            return User::model()->find($criteria);
        } else {
            return null;
        }
    }

    /**
     * Authenticate user
     *
     * @return bool Auth success
     */
    public function authenticate()
    {
        $user = $this->_getUser();

        // If there is no user with given name
        if ($user == null) {
            $this->_setError(static::ERROR_USERNAME_INVALID);

        // If password is invalid
        } elseif (!$user->checkPassword($this->password)) {
            $this->_setError(static::ERROR_PASSWORD_INVALID);

        // If success
        } else {
            $this->_afterSuccessAuthenticate($user);
        }

        return !$this->errorCode;
    }

    /**
     * Set error code and message
     *
     * @param int $errorCode
     */
    protected function _setError($errorCode) {
        $this->errorCode = $errorCode;
        switch ($this->errorCode) {
            default:
            case static::ERROR_UNKNOWN_IDENTITY:
                $this->errorMessage = \yii::t('app', 'Unknown identity');
                break;
            case static::ERROR_NONE:
                $this->errorMessage = '';
                break;
            case static::ERROR_USERNAME_INVALID:
                $this->errorMessage = \yii::t('app', 'E-mail is invalid');
                break;
            case static::ERROR_PASSWORD_INVALID:
                $this->errorMessage = \yii::t('app', 'Password is invalid');
                break;
        }
    }

    /**
     * If user authenticated successfully
     *
     * @param User $user
     */
    protected function _afterSuccessAuthenticate(User $user)
    {
        // Set no error
        $this->_setError(static::ERROR_NONE);

        // Set states
        $this->_id = (string)$user->_id;
    }

    /**
     * Override parent method to return user ID instead of user name
     *
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

}