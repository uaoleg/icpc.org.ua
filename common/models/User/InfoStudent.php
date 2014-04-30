<?php

namespace common\models\User;

class InfoStudent extends InfoAbstract
{

    /**
     * Field of study
     */
    public $studyField;

    /**
     * Speciality of study
     * @var string
     */
    public $speciality;

    /**
     * Faculty of study
     * @var string
     */
    public $faculty;

    /**
     * Group
     * @var string
     */
    public $group;

    /**
     * University course
     * @var int
     */
    public $course;

    /**
     * Year of admission to University
     * @var int
     */
    public $schoolAdmissionYear;

    /**
     * Student document serial number
     * @var string
     */
    public $document;

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
            'studyField'           => \yii::t('app', 'Field of study'),
            'speciality'           => \yii::t('app', 'Speciality of study'),
            'faculty'              => \yii::t('app', 'Faculty of study'),
            'group'                => \yii::t('app', 'Group'),
            'schoolAdmissionYear'  => \yii::t('app', 'Year of admission to University'),
            'course'               => \yii::t('app', 'Course'),
            'document'             => \yii::t('app', 'Document serial number')
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
            array('studyField, speciality, faculty, group, schoolAdmissionYear, document, course', 'required'),
            array('course', 'numerical', 'min' => 1, 'max' => 4)
        ));
    }



}