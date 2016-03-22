<?php

namespace common\models\User;

use \common\models\User;

class ApprovalRequest extends \common\ext\MongoDb\Document
{

    const ROLE_COACH        = 'coach';
    const ROLE_COORDINATOR  = 'coordinator';

    /**
     * User ID
     * @var string
     */
    public $userId;

    /**
     * User role to be approved
     * @var string
     */
    public $role;

    /**
     * Date created
     * @var \MongoDate
     */
    public $dateCreated;

    /**
     * Returns the attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to
     * merge the parent labels with child labels using functions like array_merge().
     *
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'userId'        => \yii::t('app', 'User ID'),
            'role'          => \yii::t('app', 'User role'),
            'dateCreated'   => \yii::t('app', 'Date created'),
        ));
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('userId, dateCreated', 'required'),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'user.approvalRequest';
    }

    /**
     * Before validate action
     *
     * @return boolean
     */
    protected function beforeValidate()
    {
        // MongoId to string
        $this->userId = (string)$this->userId;

        // Set created date
        if (empty($this->dateCreated)) {
            $this->dateCreated = new \MongoDate();
        }

        return parent::beforeValidate();
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        // Send an email notification about new approve required
        if ($this->_isFirstTimeSaved) {
            $user = User::model()->findByPk(new \MongoId($this->userId));
            if ($user && $user->getApprover()) {
                \yii::app()->cli->runCommand('email', 'coachOrCoordinatorNotify', array(
                    'emailTo'   => (string)$user->getApprover()->email,
                    'userId'    => (string)$user->_id,
                ), array(), true);
            }
        }

        parent::afterSave();
    }

    /**
     * Returns whether approval request for recently sent for given user or not
     * @param string $userId
     * @param string $role
     * @return bool
     */
    public static function isSentRecently($userId, $role)
    {
        $count = (int)User\ApprovalRequest::model()->countByAttributes(array(
            'userId'        => $userId,
            'role'          => $role,
            'dateCreated'   => array('$gte' => new \MongoDate(strtotime('-1 day')))
        ));
        return $count > 0;
    }

}
