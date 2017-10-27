<?php

namespace common\models\User;

/**
 * Coach info
 *
 * @property string $position
 * @property string $officeAddress
 * @property string $phoneWork
 * @property string $fax
 */
class InfoCoach extends Info
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_info_coach}}';
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'position'      => \yii::t('app', 'Position'),
            'officeAddress' => \yii::t('app', 'Office address'),
            'phoneWork'     => \yii::t('app', 'Work phone number'),
            'fax'           => \yii::t('app', 'Fax number')
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
            ['phoneWork', 'safe'],
            [['position', 'officeAddress'], 'required', 'except' => static::SC_ALLOW_EMPTY],
        ]);
    }

}