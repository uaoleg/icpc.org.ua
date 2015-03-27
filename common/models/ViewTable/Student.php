<?php

namespace common\models\ViewTable;

class Student extends \common\models\Person
{

    /**
     * Full name in Ukranian
     * @var string
     */
    public $nameUk;

    /**
     * Full name in English
     * @var string
     */
    public $nameEn;

    /**
     * Speciality of study
     * @var string
     */
    public $speciality;

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
     * Phone number
     * @var string
     */
    public $phone;

    /**
     * Date of birth
     * @var string
     */
    public $dateOfBirth;

    /**
     * Is approved student
     * @var boolean
     */
    public $isApprovedStudent;

    /**
     * School full name in Ukranian
     * @var string
     */
    public $schoolFullNameUk;

    /**
     * School full name in English
     * @var string
     */
    public $schoolFullNameEn;

    /**
     * This returns the name of the collection for this class
     *
     * @return string
	 */
    public function getCollectionName() {
        return 'viewtable.student';
    }

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
            'nameUk'            => \yii::t('app', 'Full Name (Ukranian)'),
            'nameEn'            => \yii::t('app', 'Full Name (English)'),
            'speciality'        => \yii::t('app', 'Speciality of study'),
            'group'             => \yii::t('app', 'Group'),
            'course'            => \yii::t('app', 'Course'),
            'phone'             => \yii::t('app', 'Phone number'),
            'dateOfBirth'       => \yii::t('app', 'Date of birth'),
            'schoolFullNameUk'  => \yii::t('app', 'School full name (Ukranian)'),
            'schoolFullNameEn'  => \yii::t('app', 'School full name (English)'),
            'isApprovedStudent' => \yii::t('app', 'Is approved student'),
        ));
    }

    /**
     * Before validate action
     *
     * @return bool
     */
    protected function beforeValidate()
    {
        // Set full name
        $this->nameUk = "{$this->lastNameUk} {$this->firstNameUk} {$this->middleNameUk}";
        $this->nameEn = "{$this->lastNameEn} {$this->firstNameEn} {$this->middleNameEn}";

        return parent::beforeValidate();
    }

}
