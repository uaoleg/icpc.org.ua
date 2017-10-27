<?php

namespace common\models\User;

use \common\models\BaseActiveRecord;

/**
 * Email confirmation
 *
 * @property int    $userId
 * @property int    $timeConfirmed
 */
class EmailConfirmation extends BaseActiveRecord
{

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

}