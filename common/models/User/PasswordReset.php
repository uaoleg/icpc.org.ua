<?php

namespace common\models\User;

/**
 * Password reset token
 *
 * @property-read bool $isValid
 */
class PasswordReset extends \common\ext\MongoDb\Document
{

    /**
     * Valid period of the token
     */
    const VALID_PERIOD = SECONDS_IN_DAY;

    /**
     * User email
     * @var string
     */
    public $email;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

    /**
     * Returns whether reset token is valid
     *
     * @return bool
     */
    public function getIsValid()
    {
        return (time() - static::VALID_PERIOD <= $this->dateCreated);
    }

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
            'email'         => \yii::t('app', 'Email'),
            'dateCreated'   => \yii::t('app', 'Date'),
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
            array('email, dateCreated', 'required'),
            array('email', 'email'),
            array('email', 'unique'),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'user.passwordReset';
	}

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'email' => array(
                'key' => array(
                    'email' => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
        ));
    }

    /**
     * Before validate action
     *
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) return false;

        // Email
        $this->email = mb_strtolower($this->email);

        // Set created date
        if ($this->dateCreated == null) {
            $this->dateCreated = time();
        }

        return true;
    }

}