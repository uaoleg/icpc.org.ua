<?php
namespace common\models;

use \common\models\School;

/**
 * Team
 *
 * @property-read User          $coach
 * @property-read School        $school
 * @property-read \EMongoCursor $members
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
    public $memberIds = array();

    /**
     * Objects of member users
     * @var array
     */
    protected $_members;

    /**
     * Team's coach
     * @var User
     */
    protected $_coach;

    /**
     * Team's school
     * @var School
     */
    protected $_school;

    /**
     * Returns members as list of the Users
     *
     * @return \EMongoCursor
     */
    public function getMembers()
    {
        if ($this->_members === null) {
            $memberMongoIds = array();
            foreach ($this->memberIds as $id) {
                $memberMongoIds[] = new \MongoId($id);
            }
            $criteria = new \EMongoCriteria();
            $criteria->addCond('_id', 'in', $memberMongoIds);
            $this->_members = User::model()->findAll($criteria);
        }
        return $this->_members;
    }

    /**
     * Returns related coach
     *
     * @return User
     */
    public function getCoach()
    {
        if ($this->_coach === null) {
            $this->_coach = User::model()->findByPk(new \MongoId($this->coachId));
        }
        return $this->_coach;
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
            'memberIds' => \yii::t('app', 'List of members')
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
            array('name, year, coachId, schoolId, memberIds', 'required'),
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
        if (count($this->memberIds) < 3) {
            $this->addError('memberIds', \yii::t('app', 'The number of members should be greater or equal then 3.'));
        } elseif (count($this->memberIds) > 4) {
            $this->addError('memberIds', \yii::t('app', 'The number of members should be less or equal then 4.'));
        }

        // Validate assigned school
        $this->school->scenario = School::SC_ASSIGN_TO_TEAM;
        $this->school->validate();
        if ($this->school->hasErrors()) {
            $this->addError('schoolId', \yii::t('app', 'Assigned school is invalid.'));
        }

        return true;
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        // If team name is changed then teamName attribute in Results needs to be changed
        if ($this->attributeHasChanged('name')) {
            $modifier = new \EMongoModifier();
            $modifier->addModifier('teamName', 'set', $this->name);
            $criteria = new \EMongoCriteria();
            $criteria->addCond('teamId', '==', (string)$this->_id);
            Result::model()->updateAll($modifier, $criteria);
        }

        parent::afterSave();
    }


}