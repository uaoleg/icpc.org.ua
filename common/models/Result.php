<?php

namespace common\models;

use CModelEvent;
use \common\models\Team;

/**
 * Class Result
 * @property-read Team $team
 */
class Result extends \common\ext\MongoDb\Document
{
    /**
     * Year of the result
     * @var integer
     */
    public $year;

    /**
     * Phase number (1|2|3)
     * @var integer
     */
    public $phase;

    /**
     *
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
     * Team object
     * @var Team
     */
    protected $_team;

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
     * Returns the object of the team
     * @return Team
     */
    public function getTeam()
    {
        if (!isset($this->_team)) {
            $this->_team = Team::model()->findByPk(new \MongoId($this->teamId));
        }
        return $this->_team;
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
            'year'       => 'Year of the result',
            'phase'      => 'Number of phase',
            'geo'        => 'Geographical position',
            'place'      => 'Place of the team',
            'teamId'     => 'ID of the team',
            'tasksTries' => 'Array of tasks => tries made',
            'tasksTime'  => 'Array of tasks => time spent',
            'total'      => 'Total points',
            'penalty'    => 'Penalty points',
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
            array('year, phase, geo, place, teamId, tasksTries, tasksTime, total, penalty', 'required'),
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
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'year_phase_teamId' => array(
                'key' => array(
                    'year'   => \EMongoCriteria::SORT_ASC,
                    'phase'  => \EMongoCriteria::SORT_ASC,
                    'teamId' => \EMongoCriteria::SORT_ASC,
                ),
                'unique' => true,
            ),
        ));
    }

    /**
     * Before validate action
     * @return bool
     */
    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        $this->setAttributes(array(
            'year'    => (int)date('Y'),
            'place'   => (int)$this->place,
            'phase'   => (int)$this->phase,
            'total'   => (int)$this->total,
            'penalty' => (int)$this->penalty,
        ), false);
        $school = \yii::app()->user->getInstance()->school;
        switch ($this->phase) {
            case 1:
                $this->geo = $school->state;
                break;
            case 2:
                $this->geo = $school->region;
                break;
            case 3:
                $this->geo = $school->country;
                break;
        }

        return true;
    }


}