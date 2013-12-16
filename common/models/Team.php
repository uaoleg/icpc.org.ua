<?php
namespace common\models;

use \common\models\School;
use \common\models\Team;

/**
 * Team
 *
 * @property-read User          $coach
 * @property-read School        $school
 * @property-read string        $schoolName
 * @property-read string        $coachName
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
     * Name of a coach in ukrainian
     * @var string
     */
    public $coachNameUk;

    /**
     * Name of a coach in english
     * @var string
     */
    public $coachNameEn;

    /**
     * ID of team's school
     * @var string
     */
    public $schoolId;

    /**
     * Name of a school in ukrainian
     * @var string
     */
    public $schoolNameUk;

    /**
     * Name of a school in english
     * @var string
     */
    public $schoolNameEn;

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
     * Returns school name in appropriate language
     *
     * @return string
     */
    public function getSchoolName()
    {
        switch ($this->useLanguage) {
            default:
            case 'uk':
                return $this->schoolNameUk;
                break;
            case 'en':
                return (!empty($this->schoolNameEn)) ? $this->schoolNameEn : $this->schoolNameUk;
                break;
        }
    }

    /**
     * Returns coach name in appropriate language
     *
     * @return string
     */
    public function getCoachName()
    {
        switch ($this->useLanguage) {
            default:
            case 'uk':
                return $this->coachNameUk;
                break;
            case 'en':
                return (!empty($this->coachNameEn)) ? $this->coachNameEn : $this->coachNameUk;
                break;
        }
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
            'name'         => \yii::t('app', 'Name of a team'),
            'year'         => \yii::t('app', 'Year in which team participated'),
            'coachId'      => \yii::t('app', 'Related coach ID'),
            'coachNameUk'  => \yii::t('app', 'Name of the coach in ukrainian'),
            'coachNameEn'  => \yii::t('app', 'Name of the coach in english'),
            'schoolId'     => \yii::t('app', 'Related school ID'),
            'schoolNameUk' => \yii::t('app', 'Full name of school in ukrainian'),
            'schoolNameEn' => \yii::t('app', 'Full name of school in english'),
            'memberIds'    => \yii::t('app', 'List of members')
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
            array('name, year, coachId, coachNameUk, coachNameEn, schoolId, schoolNameUk, schoolNameEn, memberIds', 'required'),
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

        // Set coach name and school name properties
        if (empty($this->coachNameUk)) {
            $this->coachNameUk = \web\widgets\user\Name::create(array('user' => $this->coach, 'lang' => 'uk'), true);
        }
        if (empty($this->coachNameEn)) {
            $this->coachNameEn = \web\widgets\user\Name::create(array('user' => $this->coach, 'lang' => 'en'), true);
        }
        if (empty($this->schoolNameUk)) {
            $this->schoolNameUk = $this->school->fullNameUk;
        }
        if (empty($this->schoolNameEn)) {
            $this->schoolNameEn = $this->school->fullNameEn;
        }

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

        // Check if user tries to add user who is already is some other team
        $teams = Team::model()->findAllByAttributes(array(
            '_id' => array('$ne' => $this->_id),
            'year' => $this->year,
            'memberIds' => array('$in' => $this->memberIds)
        ));
        foreach ($teams as $team) {
            $userIds = array_intersect($team->memberIds, $this->memberIds);
            foreach ($userIds as $userId) {
                $user = User::model()->findByPk(new \MongoId((string)$userId));
                $this->addError('memberIds', \yii::t('app', '{name} is already in another team.', array(
                    '{name}' => \web\widgets\user\Name::create(array('user' => $user), true)
                )));
            }
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

    protected function afterDelete()
    {
        $criteria = new EMongoCriteria();
        $criteria
            ->addCond('teamId', '==', (string)$this->_id)
            ->addCond('year', '==', (int)$this->year);
        Result::model()->deleteAll($criteria);
        parent::afterDelete();
    }


}