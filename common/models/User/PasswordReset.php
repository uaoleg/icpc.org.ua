<?php

namespace common\models\User;

use \common\models\BaseActiveRecord;

/**
 * Password reset token
 *
 * @property-read bool $isValid
 */
class PasswordReset extends BaseActiveRecord
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
    public $timeCreated;

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_password_reset}}';
    }

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorTimestamp(),
        ];
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'email'         => \yii::t('app', 'Email'),
            'timeCreated'   => \yii::t('app', 'Date'),
        ));
    }

    /**
     * Returns whether reset token is valid
     *
     * @return bool
     */
    public function getIsValid()
    {
        return (time() - static::VALID_PERIOD <= $this->timeCreated);
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique'],
        ]);
    }

    /**
     * Before save action
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Email to lower case
        $this->email = mb_strtolower($this->email);

        return true;
    }

}