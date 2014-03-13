<?php
namespace common\models;

use \common\models\School;

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
     * Scenarios
     */
    const SC_PHASE_UPDATE   = 'phaseUpdate';
    const SC_USER_DELETING  = 'userDeleting';

    /**
     * League values
     */
    const LEAGUE_NULL   = null;
    const LEAGUE_I      = 'I';
    const LEAGUE_II     = 'II';

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
     * Phase the team participates in
     * @var int
     */
    public $phase = Result::PHASE_1;

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
     * League
     * I-offers advanced degree in computer science
     * II-does not offer advanced degree in computer science
     * @var string
     */
    public $league = self::LEAGUE_NULL;

    /**
     * List of members IDs
     * @var array
     */
    public $memberIds = array();

    /**
     * State labels of a team
     * @var array
     */
    public $state = array();

    /**
     * Region labels of a team
     * @var array
     */
    public $region = array();

    /**
     * Is team deleted
     * @var bool
     */
    public $isDeleted = false;

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
     * Returns team's state label
     *
     * @return string
     */
    public function getStateLabel()
    {
        if (isset($this->state[$this->useLanguage])) {
            return $this->state[$this->useLanguage];
        } else {
            return $this->state['uk'];
        }
    }

    /**
     * Returns team's region label
     *
     * @return string
     */
    public function getRegionLabel()
    {
        if (isset($this->region[$this->useLanguage])) {
            return $this->region[$this->useLanguage];
        } else {
            return $this->region['uk'];
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
            'name'          => \yii::t('app', 'Name of a team'),
            'year'          => \yii::t('app', 'Year in which team participates'),
            'phase'         => \yii::t('app', 'Stage in which team participates'),
            'coachId'       => \yii::t('app', 'Related coach ID'),
            'coachNameUk'   => \yii::t('app', 'Name of the coach in ukrainian'),
            'coachNameEn'   => \yii::t('app', 'Name of the coach in english'),
            'schoolId'      => \yii::t('app', 'Related school ID'),
            'schoolNameUk'  => \yii::t('app', 'Full name of school in ukrainian'),
            'schoolNameEn'  => \yii::t('app', 'Full name of school in english'),
            'league'        => \yii::t('app', 'League of a team'),
            'memberIds'     => \yii::t('app', 'List of members'),
            'state'         => \yii::t('app', 'List of state labels of a team'),
            'region'        => \yii::t('app', 'List of region labels of a team'),
            'isDeleted'     => \yii::t('app', 'Is team deleted'),
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
            array('name, year, phase, coachId, coachNameUk, coachNameEn, schoolId, schoolNameUk, schoolNameEn,
                   memberIds, state, region', 'required'),
            array('name', Team\Validator\Name::className()),
            array('year', 'numerical',
                'integerOnly'   => true,
                'min'           => (int)\yii::app()->params['yearFirst'],
                'max'           => (int)date('Y'),
            ),
            array('phase', 'readonly', 'except' => static::SC_PHASE_UPDATE),
            array('phase', Team\Validator\Phase::className()),
            array('phase', 'numerical',
                'integerOnly'   => true,
                'min'           => Result::PHASE_1,
                'max'           => Result::PHASE_3 + 1,
            ),
            array('schoolId', Team\Validator\School::className()),
            array('league', Team\Validator\League::className()),
            array('memberIds', Team\Validator\Members::className(), 'except' => static::SC_USER_DELETING),
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
        if (!parent::beforeValidate()) {
            return false;
        }

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
            $this->year = (int)date('Y');
        }

        // Set state and region labels
        if ($this->attributeHasChanged('schoolId')) {
            $initLang = \yii::app()->language;
            foreach (\yii::app()->params['languages'] as $language => $label) {
                \yii::app()->language = $language;
                $this->state[$language] = $this->school->getStateLabel();
                $this->region[$language] = $this->school->getRegionLabel();
            }
            \yii::app()->language = $initLang;
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

    /**
     * After delete action
     */
    protected function afterDelete()
    {
        // After team is deleted results for it should be removed too
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('teamId', '==', (string)$this->_id)
            ->addCond('year', '==', (int)$this->year);
        Result::model()->deleteAll($criteria);

        parent::afterDelete();
    }

    /**
     * Scope for active teams
     *
     * @return Team
     */
    public function scopeByActive()
    {
        $criteria = $this->getDbCriteria();
        $criteria->addCond('isDeleted', '==', false);
        $this->setDbCriteria($criteria);

        return $this;
    }

}
