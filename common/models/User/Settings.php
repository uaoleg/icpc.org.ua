<?php

namespace common\models\User;

use \common\models\BaseActiveRecord;

/**
 * User's settings
 *
 * @property int    $userId
 * @property int    $year
 * @property string $geo
 * @property string $lang
 */
class Settings extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_settings}}';
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'userId'    => \yii::t('app', 'User ID'),
            'year'      => \yii::t('app', 'Year'),
            'geo'       => \yii::t('app', 'Geo'),
            'lang'      => \yii::t('app', 'Language'),
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
        ]);
    }

}