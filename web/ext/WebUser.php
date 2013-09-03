<?php

namespace web\ext;

use \common\models\User;

class WebUser extends \CWebUser
{

    /**
     * Link to User object
     * @var User
     */
    protected $_user;

    /**
     * Access cache
     * @var array
     */
    protected $_access = array();

    /**
     * Init Web User
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Get user instance
     *
     * @param bool $find
     * @return User
     */
    public function getInstance($find = true)
    {
        if ($this->_user === null) {
            if ($find) {
                $this->_user = User::model()->findByPk(new \MongoId($this->getId()));
            }
            if ($this->_user === null) {
                $this->_user = new User();
            }
        }
        return $this->_user;
    }

    /**
     * Logs in a user
     *
     * @param \IUserIdentity $identity
     * @param int $duration
     * @return bool
     */
    public function login($identity, $duration = 0)
    {
        $success = parent::login($identity, $duration);
        if ($success) {
            $this->_user = null;
        }
        return $success;
    }

    /**
     * After logout action
     */
    protected function afterLogout()
    {
        // Clear access cache
        $this->_access = array();

        parent::afterLogout();
    }

	/**
	 * Performs access check for this user.
     *
	 * @param string $operation
	 * @param array $params
	 * @param bool $allowCaching
	 * @return bool whether the operations can be performed by this user.
	 */
	public function checkAccess($operation, $params = array(), $allowCaching = true)
	{
		if (($allowCaching) && ($params === array()) && (isset($this->_access[$operation]))) {
			return $this->_access[$operation];
        }

        $userId = $this->getId();
		$access = \yii::app()->getAuthManager()->checkAccess($operation, $userId, $params);
		if (($allowCaching) && ($params === array())) {
			$this->_access[$operation] = $access;
        }

		return $access;
	}

}