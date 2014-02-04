<?php

namespace common\models;

use \common\models\Team;

/**
 * Team Result
 *
 * @property-read string $schoolName
 * @property-read string $coachName
 * @property-read bool   $phaseIsCompleted
 * @property-read string $geoType
 * @property-read Team   $team
 */
class Result extends \common\ext\MongoDb\Document
{

    /**
     * List of available phases
     */
    const PHASE_1 = 1; // State
    const PHASE_2 = 2; // Region
    const PHASE_3 = 3; // Ukraine

    /**
     * Letters for tasks
     */
    const TASKS_LETTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Year of the result
     * @var integer
     */
    public $year;

    /**
     * Phase number
     * @var integer
     */
    public $phase;

    /**
     * Name of the state, region or country (phase-related)
     * @var string
     */
    public $geo;

    /**
     * Place of team
     * @var integer
     */
    public $place;

    /**
     * ID of the team
     * @var string
     */
    public $teamId;

    /**
     * Name of a team
     * @var string
     * @see beforeValidate()
     */
    public $teamName;

    /**
     * School ID
     * @var string
     * @see beforeValidate()
     */
    public $schoolId;

    /**
     * School name of the result's team in ukrainian
     * @var string
     * @see beforeValidate()
     */
    public $schoolNameUk;

    /**
     * School name of the result's team in english
     * @var string
     * @see beforeValidate()
     */
    public $schoolNameEn;

    /**
     * Coach ID
     * @var string
     * @see beforeValidate()
     */
    public $coachId;

    /**
     * Coach name of the result's team in ukrainian
     * @var string
     * @see beforeValidate()
     */
    public $coachNameUk;

    /**
     * Coach name of the result's team in english
     * @var string
     * @see beforeValidate()
     */
    public $coachNameEn;

    /**
     * Array of tasks => number of tries
     * @var array
     */
    public $tasksTries = array();

    /**
     * Array of tasks => time spent
     * @var array
     */
    public $tasksTime = array();

    /**
     * Total points
     * @var integer
     */
    public $total;

    /**
     * Penalty points
     * @var integer
     */
    public $penalty;

    /**
     * Team object
     * @var Team
     */
    protected $_team;

    /**
     * Is phase completed
     * @var bool
     */
    protected $_phaseIsCompleted;

    /**
     * Returns the object of the team
     * @return Team
     */
    public function getTeam()
    {
        if ($this->_team === null) {
            $this->_team = Team::model()->findByPk(new \MongoId($this->teamId));
        }
        return $this->_team;
    }

    /**
     * Returns whether the phase is completed
     *
     * @return bool
     */
    public function getPhaseIsCompleted()
    {
        if ($this->_phaseIsCompleted === null) {
            if ($this->team !== null) {
                $this->_phaseIsCompleted = ($this->phase + 1 <= $this->team->phase);
            } else {
                $this->_phaseIsCompleted = false;
            }
        }
        return $this->_phaseIsCompleted;
    }

    /**
     * Returns geo type
     *
     * @return string
     */
    public function getGeoType()
    {
        switch ($this->phase) {
            case static::PHASE_1:
                return 'state';
                break;
            case static::PHASE_2:
                return 'region';
                break;
            case static::PHASE_3:
                return 'country';
                break;
        }
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
                return (!empty($this->schoolNameEn)) ? $this->coachNameEn : $this->coachNameUk;
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
            'year'          => \yii::t('app', 'Year of the result'),
            'phase'         => \yii::t('app', 'Number of stage'),
            'geo'           => \yii::t('app', 'Geographical position'),
            'place'         => \yii::t('app', 'Place of the team'),
            'teamId'        => \yii::t('app', 'ID of the team'),
            'teamName'      => \yii::t('app', 'Name of the team'),
            'schoolId'      => \yii::t('app', 'School ID'),
            'schoolNameUk'  => \yii::t('app', 'School name in ukrainian'),
            'schoolNameEn'  => \yii::t('app', 'School name in english'),
            'coachId'       => \yii::t('app', 'Coach ID'),
            'coachNameUk'   => \yii::t('app', 'Coach name in ukrainian'),
            'coachNameEn'   => \yii::t('app', 'Coach name in english'),
            'tasksTries'    => \yii::t('app', 'Array of tasks => tries made'),
            'tasksTime'     => \yii::t('app', 'Array of tasks => time spent'),
            'total'         => \yii::t('app', 'Total points'),
            'penalty'       => \yii::t('app', 'Penalty points'),
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
            array('year, phase, geo, place, teamName, tasksTries, tasksTime', 'required'),
            array('place', 'numerical', 'min' => 1)
        ));
    }

    /**
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'results';
    }

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'year_phase_teamName' => array(
                'key' => array(
                    'year'     => \EMongoCriteria::SORT_ASC,
                    'phase'    => \EMongoCriteria::SORT_ASC,
                    'teamName' => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
            'coachId' => array(
                'key' => array(
                    'coachId' => \EMongoCriteria::SORT_ASC,
                )
            ),
            'schoolId' => array(
                'key' => array(
                    'schoolId' => \EMongoCriteria::SORT_ASC,
                )
            ),
            'teamId' => array(
                'key' => array(
                    'teamId' => \EMongoCriteria::SORT_ASC,
                )
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

        // Set year
        if (empty($this->year)) {
            $this->year = (int)date('Y');
        }

        // Convert to string
        $this->teamId = (isset($this->teamId)) ? (string)$this->teamId : null;

        // Save school and coach info if team exists
        if (isset($this->teamId)) {
            $this->setAttributes(array(
                'schoolId'      => (string)$this->team->school->_id,
                'schoolNameUk'  => $this->team->school->fullNameUk,
                'schoolNameEn'  => $this->team->school->fullNameEn,
                'coachId'       => (string)$this->team->coach->_id,
                'coachNameUk'   => \web\widgets\user\Name::create(array('user' => $this->team->coach, 'lang' => 'uk'), true),
                'coachNameEn'   => \web\widgets\user\Name::create(array('user' => $this->team->coach, 'lang' => 'en'), true),
            ), false);
        }

        // Convert to integer
        $this->setAttributes(array(
            'year'      => (int)$this->year,
            'place'     => (int)$this->place,
            'phase'     => (int)$this->phase,
            'total'     => (int)$this->total,
            'penalty'   => (int)$this->penalty,
        ), false);

        return true;
    }

}