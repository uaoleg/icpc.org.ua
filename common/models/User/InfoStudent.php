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
     * Year of admission to University
     * @var int
     */
    public $instAdmissionYear;

    /**
     * Date of birth
     * @var string
     */
    public $dateOfBirth;

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
            'studyField'         => \yii::t('app', 'Field of study'),
            'speciality'         => \yii::t('app', 'Speciality of study'),
            'faculty'            => \yii::t('app', 'Faculty of study'),
            'group'              => \yii::t('app', 'Group'),
            'instAdmissionYear'  => \yii::t('app', 'Year of admission to University'),
            'dateOfBirth'        => \yii::t('app', 'Date of birth'),
            'document'           => \yii::t('app', 'Document serial number')
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
            array('studyField, speciality, faculty, group, instAdmissionYear, dateOfBirth, document', 'required'),
        ));
    }



}