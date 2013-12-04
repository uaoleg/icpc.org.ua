<?php

namespace common\models;

use \common\models\Team;

/**
 * Team Result
 *
 * @property-read string $schoolName
 * @property-read string $coachName
 * @property-read Team   $team
 */
class Result extends \common\ext\MongoDb\Document
{

    /**
     * List of available phases
     */
    const PHASE_1 = 1;
    const PHASE_2 = 2;
    const PHASE_3 = 3;

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
     * School name of the result's team in ukrainian
     * @var string
     */
    public $schoolNameUk;

    /**
     * School name of the result's team in english
     * @var string
     */
    public $schoolNameEn;

    /**
     * Coach name of the result's team in ukrainian
     * @var string
     */
    public $coachNameUk;

    /**
     * Coach name of the result's team in english
     * @var string
     */
    public $coachNameEn;

    /**
     * Name of a team
     * @var string
     */
    public $teamName;

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
     * Returns school name in appropriate language
     * @param  string $lang
     * @return string
     */
    public function getSchoolName($lang = null) {
        $lang = isset($lang) ? $lang : \yii::app()->language;
        switch ($lang) {
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
     * @param  string $lang
     * @return string
     */
    public function getCoachName($lang = null) {
        $lang = isset($lang) ? $lang : \yii::app()->language;
        switch ($lang) {
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
            'year'         => 'Year of the result',
            'phase'        => 'Number of phase',
            'geo'          => 'Geographical position',
            'place'        => 'Place of the team',
            'teamId'       => 'ID of the team',
            'schoolNameUk' => 'School name in ukrainian',
            'schoolNameEn' => 'School name in english',
            'coachNameUk'  => 'Coach name in ukrainian',
            'coachNameEn'  => 'Coach name in english',
            'teamName'     => 'Name of the team',
            'tasksTries'   => 'Array of tasks => tries made',
            'tasksTime'    => 'Array of tasks => time spent',
            'total'        => 'Total points',
            'penalty'      => 'Penalty points',
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
            'teamId' => array(
                'key' => array(
                    'teamId' => \EMongoCriteria::SORT_ASC
                )
            )
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

        // Save school and coach info if team exists
        if (isset($this->teamId)) {
            $this->setAttributes(array(
                'teamId'        => (string)$this->teamId,
                'schoolNameUk'  => $this->team->school->fullNameUk,
                'schoolNameEn'  => $this->team->school->fullNameEn,
                'coachNameUk'   => \web\widgets\user\Name::create(array('user' => $this->team->coach, 'lang' => 'uk'), true),
                'coachNameEn'   => \web\widgets\user\Name::create(array('user' => $this->team->coach, 'lang' => 'en'), true),
            ), false);
        } else {
            $this->setAttributes(array(
                'teamId'        => null,
                'schoolNameUk'  => null,
                'schoolNameEn'  => null,
                'coachNameUk'   => null,
                'coachNameEn'   => null,
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