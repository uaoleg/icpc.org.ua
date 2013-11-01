<?php

namespace common\models;

use \common\models\School;

class Team extends \common\ext\MongoDb\Document
{

    /**
     * number of needed members in team
     */
    const COUNT_NEEDED_MEMBERS = 3;
    /**
     * number of maximum members in team
     */
    const COUNT_MAX_MEMBERS = 4;

    /**
     * Name of a team
     * @var string
     */
    public $name;

    /**
     * Name of a team concatenated with short english name of school as a prefix
     * @var string
     */
    public $nameWithPrefix;

    /**
     * Year in which team participated
     * @var string
     */
    public $year;

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
     * This returns the name of the collection for this class
     *
     * @return string
     */
    public function getCollectionName()
    {
        return 'team';
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
            'name' => \yii::t('app', 'Team name'),
            'schoolId' => \yii::t('app', 'ID of team\'s school'),
            'members' => \yii::t('app', 'List of members')
        ));
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('name, schoolId', 'required'),
            array('name', 'unique'),
        ));
    }

    /**
     * Returns the number of team members
     * @return int
     */
    public function getMembersCount()
    {
        return count($this->members);
    }

    /**
     * Method which adds user with given ID to the team
     * @param  $userId string ID of user to be added
     * @return         bool   if user was added to team or not
     */
    public function addMember($userId)
    {
        if ($this->getMembersCount() < self::COUNT_MAX_MEMBERS) {
            $this->members = array_merge($this->members, $userId);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method which removes user with given ID from the team
     * @param  $userId string ID of user to be removed
     * @return         bool   if user was deleted or not
     */
    public function removeMember($userId)
    {
        $key = array_search($userId, $this->members);
        if ($key !== false) {
            unset($this->members[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets name with prefix
     */
    public function setNameWithPrefix()
    {
        $school = School::model()->find(array('_id' => $this->schoolId));
        $this->nameWithPrefix = $school->shortNameEn . $this->name;
    }

    /**
     * After save action
     */
    protected function afterSave()
    {
        $this->setNameWithPrefix();

        parent::afterSave();
    }

}