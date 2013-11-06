<?php
namespace common\models;

use CModelEvent;
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
     * ID of team's coach
     * @var string
     */
    public $coachId;

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
            'name'     => \yii::t('app', 'Name of a team'),
            'schoolId' => \yii::t('app', 'ID of team\'s school'),
            'members'  => \yii::t('app', 'List of members')
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

    protected function beforeValidate()
    {
        if (!parent::beforeValidate()) return false;

        if (count($this->members) !== count(array_unique($this->members))) {
            $this->addError('member4', \yii::t('app', 'You cannot add a person to team more than once. Check and try again.'));
        }

//        var_dump($this->schoolId);
        $school = School::model()->findByPk(new \MongoId($this->schoolId));

        if (empty($school->shortNameUk)) {
            $this->addError('shortNameUk', \yii::t('app', '{attr} cannot be empty', array(
                '{attr}' => $school->getAttributeLabel('shortNameUk')
            )));
        }

        if (empty($school->fullNameEn)) {
            $this->addError('fullNameEn', \yii::t('app', '{attr} cannot be empty', array(
                '{attr}' => $school->getAttributeLabel('fullNameEn')
            )));
        }

        if (empty($school->shortNameEn)) {
            $this->addError('shortNameEn', \yii::t('app', '{attr} cannot be empty', array(
                '{attr}' => $school->getAttributeLabel('shortNameEn')
            )));
        }

        return true;
    }


}