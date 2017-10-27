<?php

namespace common\models\User;

/**
 * Student info
 *
 * @property string $studyField
 * @property string $speciality
 * @property string $faculty
 * @property string $group
 * @property int    $course
 * @property int    $schoolAdmissionYear
 * @property string $document
 */
class InfoStudent extends Info
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_info_student}}';
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'studyField'           => \yii::t('app', 'Field of study'),
            'speciality'           => \yii::t('app', 'Speciality of study'),
            'faculty'              => \yii::t('app', 'Faculty of study'),
            'group'                => \yii::t('app', 'Group'),
            'schoolAdmissionYear'  => \yii::t('app', 'Year of admission to University'),
            'course'               => \yii::t('app', 'Course'),
            'document'             => \yii::t('app', 'Document serial number'),
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
            [['studyField', 'speciality', 'faculty', 'group', 'schoolAdmissionYear', 'document', 'course'], 'required', 'except' => static::SC_ALLOW_EMPTY],
            ['course', 'number', 'min' => 1, 'max' => 5],
        ]);
    }

}
