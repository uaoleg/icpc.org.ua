<?php

namespace common\models;

use \common\models\School;

/**
 * Team
 *
 * @property string $name
 * @property int    $year
 * @property int    $phase
 * @property int    $coachId
 * @property int    $schoolId
 * @property string $baylorId
 * @property string $league
 * @property bool   $isDeleted
 * @property bool   $isOutOfCompetition
 * @property int    $timeCreated
 * @property int    $timeUpdated
 *
 * @property-read User          $coach
 * @property-read School        $school
 * @property-read string        $schoolName
 * @property-read string        $coachName
 * @property-read Team\Member[] $members
 */
class Team extends BaseActiveRecord
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
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%team}}';
    }

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorTimestamp(),
        ];
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'name'                  => \yii::t('app', 'Name of a team'),
            'year'                  => \yii::t('app', 'Year in which team participates'),
            'phase'                 => \yii::t('app', 'Stage in which team participates'),
            'coachId'               => \yii::t('app', 'Related coach ID'),
            'schoolId'              => \yii::t('app', 'Related school ID'),
            'league'                => \yii::t('app', 'League of a team'),
            'isDeleted'             => \yii::t('app', 'Is team deleted'),
            'isOutOfCompetition'    => \yii::t('app', 'Is team out of a competition'),
        ));
    }

    /**
     * Returns members as list of the Users
     * @return \yii\db\ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasMany(Team\Member::class, ['teamId' => 'id']);
    }

    /**
     * Returns if team has given member
     * @param int $userId
     * @return bool
     */
    public function hasMember($userId)
    {
        return (int)$this->getMembers()->andWhere(['userId' => $userId])->count() > 0;
    }

    /**
     * Returns related coach
     * @return \yii\db\ActiveQuery
     */
    public function getCoach()
    {
        return $this->hasOne(User::class, ['id' => 'coachId']);
    }

    /**
     * Returns related school
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(School::class, ['id' => 'schoolId']);
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [

            [['name', 'coachId', 'schoolId'], 'required'],

            ['name', Team\Validator\Name::class],
            ['name', Team\Validator\Unique::class],

            ['year', 'default', 'value' => date('Y')],
            ['year', 'number',
                'integerOnly'   => true,
                'min'           => (int)\yii::$app->params['yearFirst'],
                'max'           => (int)date('Y'),
            ],

            ['phase', 'default', 'value' => Result::PHASE_1],
            ['phase', Team\Validator\Phase::class],
            ['phase', 'number',
                'integerOnly'   => true,
                'min'           => Result::PHASE_1,
                'max'           => Result::PHASE_3 + 1,
            ],

            ['schoolId', Team\Validator\School::class],

            ['league', 'default', 'value' => static::LEAGUE_NULL],
            ['league', Team\Validator\League::class],

            [['isDeleted', 'isOutOfCompetition'], 'boolean'],

        ]);
    }

}
