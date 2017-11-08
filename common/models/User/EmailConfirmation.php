<?php

namespace common\models\User;

use \common\models\BaseActiveRecord;

/**
 * Email confirmation
 *
 * @property int    $userId
 * @property string $hash
 * @property int    $timeConfirmed
 */
class EmailConfirmation extends BaseActiveRecord
{

    const HASH_LENGTH = 50;

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_email_confirmation}}';
    }

    /**
     * Returns the attribute labels.
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
        return array_merge(parent::rules(), [
            ['userId', 'required'],
            ['userId', 'unique'],

            ['timeConfirmed', 'default', 'value' => time()],
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

        // Generate hash
        if (empty($this->hash)) {
            $this->hash = time();
            $this->hash .= \yii::$app->security->generateRandomString(static::HASH_LENGTH - mb_strlen($this->hash));
        }

        return true;
    }

}