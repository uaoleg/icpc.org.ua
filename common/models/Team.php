<?php
namespace common\models;

use \common\models\School;

/**
 * Team
 *
 * @property-read User   $coach
 * @property-read School $school
 */
class Team extends \common\ext\MongoDb\Document
{

    /**
     * Name of a team
     * @var string
     */
    public $name;

    /**
     * Year in which team participated
     * @var int
     */
    public $year;

    /**
     * ID of team's coach
     * @var string
     */
    public $coachId;

    /**
     * ID of team's school
     * @var string
     */
    public $schoolId;

    /**
     * List of members IDs
     * @var array
     */
    public $members = array();

    /**
     * Team's coach
     * @var User
     */
    protected $_coach;

    /**
     * Team's school
     * @var Team
     */
    protected $_school;

    /**
     * Returns related coach
     *
     * @return User
     */
    public function getCoach()
    {
        if ($this->_coach === null) {
            $this->_school = User::model()->findByPk(new \MongoId($this->coachId));
        }
        return $this->_school;
    }

    /**
     * Returns related school
     *
     * @return School
     */
    public function getSchool()
    {
        if ($this->_school === null) {
            $this->_school = School::model()->findByPk(new \MongoId($this->schoolId));
        }
        return $this->_school;
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
            'name'      => \yii::t('app', 'Name of a team'),
            'year'      => \yii::t('app', 'Year in which team participated'),
            'coachId'   => \yii::t('app', 'Related coach ID'),
            'schoolId'  => \yii::t('app', 'Related school ID'),
            'members'   => \yii::t('app', 'List of members')
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
            array('name, year, coachId, schoolId, members', 'required'),
            array('year', 'numerical',
                'integerOnly'   => true,
                'min'           => (int)\yii::app()->params['yearFirst'],
                'max'           => (int)date('Y')
            ),
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'team';
    }

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'year_name' => array(
                'key' => array(
                    'year' => \EMongoCriteria::SORT_DESC,
                    'name' => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
        ));
    }

    /**
     * Before validate action
     *
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) return false;

        // Convert MongoId to String
        $this->coachId = (string)$this->coachId;
        $this->schoolId = (string)$this->schoolId;

        // Year
        if (empty($this->year)) {
            $this->year = date('Y');
        }
        $this->year = (int)$this->year;

        // Members
        $this->members = array_unique($this->members);
        if (count($this->members) < 3) {
            $this->addError('members', \yii::t('app', 'The nubmer of members should be greater or equal then 3.'));
        } elseif (count($this->members) > 4) {
            $this->addError('members', \yii::t('app', 'The nubmer of members should be less or equal then 4.'));
        }

        // Check school names to be not empty
        if (empty($this->school->shortNameUk)) {
            $this->addError('schoolShortNameUk', \yii::t('app', '{attr} cannot be empty', array(
                '{attr}' => $this->school->getAttributeLabel('shortNameUk')
            )));
        }
        if (empty($this->school->fullNameEn)) {
            $this->addError('schoolFullNameEn', \yii::t('app', '{attr} cannot be empty', array(
                '{attr}' => $this->school->getAttributeLabel('fullNameEn')
            )));
        }
        if (empty($this->school->shortNameEn)) {
            $this->addError('schoolShortNameEn', \yii::t('app', '{attr} cannot be empty', array(
                '{attr}' => $this->school->getAttributeLabel('shortNameEn')
            )));
        }

        return true;
    }


}