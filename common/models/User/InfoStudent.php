<?php

namespace common\models\User;

class InfoStudent extends InfoAbstract
{

    /**
     * Field of student's study
     */
    public $studentStudyField;

    /**
     * Speciality of study
     * @var string
     */
    public $studentSpeciality;

    /**
     * Faculty of study
     * @var string
     */
    public $studentFaculty;

    /**
     * Student's group
     * @var string
     */
    public $studentGroup;

    /**
     * The year student is on
     * @var string
     */
    public $studentYear;

    /**
     * Date of birth
     * @var string
     */
    public $studentDateOfBirth;

    /**
     * Year which student entered university
     * @var string
     */
    public $studentUnivesityEntryYear;

    /**
     * Student document serial number
     * @var string
     */
    public $studentDocument;

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
            'studentStudyField'         => \yii::t('app', 'Field of student\'s study'),
            'studentSpeciality'         => \yii::t('app', 'Speciality of study'),
            'studentFaculty'            => \yii::t('app', 'Faculty of study'),
            'studentGroup'              => \yii::t('app', 'Student\' group'),
            'studentYear'               => \yii::t('app', 'Student\'s year of study'),
            'studentDateOfBirth'        => \yii::t('app', 'Student\'s date of birth'),
            'studentUnivesityEntryYear' => \yii::t('app', 'Year which student entered the university'),
            'studentDocument'           => \yii::t('app', 'Student\'s document serial number')
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
            array('studentStudyField, studentSpeciality, studentFaculty, studentGroup, studentYear, studentDateOfBirth,
                studentUnivesityEntryYear, studentStudentDocument', 'required'),
        ));
    }



}