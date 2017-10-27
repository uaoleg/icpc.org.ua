<?php

namespace common\models\Team;

use \common\models\BaseActiveRecord;
use \common\models\Team;
use \common\models\User;

/**
 * Team member relationship
 *
 * @property int $teamId
 * @property int $userId
 *
 * @property-read Team $team
 * @property-read User $user
 */
class Member extends BaseActiveRecord
{

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%team_member}}';
    }

    /**
     * Returns the validation rules for attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['teamId', 'userId'], 'required'],
            ['userId', 'unique', 'targetAttribute' => ['teamId', 'userId']],
        ];
    }

    /**
     * Returns related team
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::class, ['id' => 'teamId']);
    }

    /**
     * Returns related user
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'userId']);
    }

    public static function updateTeamMembers(Team $team, array $memberIds)
    {
        // Validate
        $team->clearErrors('members');
        if (count($memberIds) < 3) {
            $team->addError('members', \yii::t('app', 'The number of members should be greater or equal then 3.'));
        } elseif (count($memberIds) > 4) {
            $team->addError('members', \yii::t('app', 'The number of members should be less or equal then 4.'));
        } else {

            // Check if user tries to add user who is already is some other team
            $otherTeamsMembers = static::find()
                ->andWhere(['!=', 'teamId', $team->id])
                ->andWhere(['userId' => $memberIds])
                ->all()
            ;
            foreach ($otherTeamsMembers as $member) {
                $team->addError('members', \yii::t('app', '{name} is already in another team.', array(
                    '{name}' => \frontend\widgets\user\Name::widget(array('user' => $member->user))
                )));
            }
        }
        if ($team->hasErrors('members')) {
            return false;
        }

        // Delete old members
        static::deleteAll(['teamId' => $team->id]);

        // Insert new members
        foreach ($memberIds as $memberId) {
            (new static([
                'teamId' => $team->id,
                'userId' => $memberId,
            ]))->save();
        }

        return true;
    }

}
