<?php

namespace common\models\User;

class EmailConfirmation extends \common\ext\MongoDb\Document
{

    /**
     * User ID
     * @var string
     */
    public $userId;

    /**
     * Date when email was confirmed
     * @var \MongoDate
     */
    public $dateConfirmed = false;

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
            'userId' => \yii::t('app', 'User ID'),
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
            array('userId', 'required'),
            array('userId', 'unique'),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'user.emailConfirmation';
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

        // Save date when email was confirmed
        if (empty($this->dateConfirmed)) {
            $this->dateConfirmed = new \MongoDate();
        }

        return parent::beforeValidate();
    }

}