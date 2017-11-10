<?php

namespace common\models;

use \common\models\Team;

/**
 * Team Result
 *
 * @property int    $teamId
 * @property string $teamName // Name of team that is not registered
 * @property int    $year
 * @property int    $phase
 * @property string $geo
 * @property int    $place
 * @property string $placeText
 * @property int    $prizePlace
 * @property int    $total
 * @property int    $penalty
 *
 * @property-read string        $schoolName
 * @property-read string        $coachName
 * @property-read bool          $phaseIsCompleted
 * @property-read string        $geoType
 * @property-read Result\Task[] $tasks
 * @property-read Team          $team
 */
class Result extends BaseActiveRecord
{

    /**
     * List of available phases
     */
    const PHASE_1 = 1; // State
    const PHASE_2 = 2; // Region
    const PHASE_3 = 3; // Ukraine

    /**
     * List of prize places
     */
    const PRIZE_PLACE_1     = 1;
    const PRIZE_PLACE_2     = 2;
    const PRIZE_PLACE_3     = 3;
    const PRIZE_PLACE_NO    = 4;

    /**
     * Letters for tasks
     */
    const TASKS_LETTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Is phase completed
     * @var bool
     */
    protected $_phaseIsCompleted;

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%result}}';
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'year'          => \yii::t('app', 'Year of the result'),
            'phase'         => \yii::t('app', 'Number of stage'),
            'geo'           => \yii::t('app', 'Geographical position'),
            'place'         => \yii::t('app', 'Absolute Place'),
            'placeText'     => \yii::t('app', 'Absolute Place'),
            'prizePlace'    => \yii::t('app', 'Prize Place'),
            'teamId'        => \yii::t('app', 'ID of the team'),
            'schoolNameUk'  => \yii::t('app', 'School name in ukrainian'),
            'schoolNameEn'  => \yii::t('app', 'School name in english'),
            'schoolType'    => \yii::t('app', 'School type'),
            'coachId'       => \yii::t('app', 'Coach ID'),
            'coachNameUk'   => \yii::t('app', 'Coach name in ukrainian'),
            'coachNameEn'   => \yii::t('app', 'Coach name in english'),
            'total'         => \yii::t('app', 'Total points'),
            'penalty'       => \yii::t('app', 'Penalty points'),
        ));
    }

    /**
     * Define attribute rules
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [

            ['year', 'default', 'value' => date('Y')],

            ['place', 'required'],
            ['place', 'number', 'min' => 1],

            ['prizePlace', 'number', 'min' => static::PRIZE_PLACE_1, 'max' => static::PRIZE_PLACE_NO],
            ['prizePlace', 'default', 'value' => static::PRIZE_PLACE_NO],

            [['phase', 'geo'], 'required'],

        ]);
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
     * Returns school full name in appropriate language
     * @return string
     */
    public function getSchoolName()
    {
        switch (static::$useLanguage) {
            default:
            case 'uk':
                return $this->school->fullNameUk;
            case 'en':
                return (!empty($this->school->fullNameEn)) ? $this->school->fullNameEn : $this->school->fullNameUk;
        }
    }

    /**
     * Returns coach name in appropriate language
     *
     * @return string
     */
    public function getCoachName()
    {
        switch (static::$useLanguage) {
            default:
            case 'uk':
                $lang = 'uk';
                break;
            case 'en':
                $lang = (!empty($this->coachNameEn)) ? 'en' : 'uk';
                break;
        }
        return \frontend\widgets\user\Name::widget(['user' => $this->coach, 'lang' => $lang]);
    }

    /**
     * Returns related tasks
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this
            ->hasMany(Result\Task::class, ['resultId' => 'id'])
            ->orderBy('letter')
        ;
    }

    /**
     * Returns the object of the team
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'teamId']);
    }

}
