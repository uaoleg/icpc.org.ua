<?php

namespace common\models\User;

use \common\models\BaseActiveRecord;

/**
 * User photo
 *
 * @property int    $userId
 * @property string $content
 */
class Photo extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_photo}}';
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'userId'   => \yii::t('app', 'ID of a user')
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
        ]);
    }

}
