<?php

namespace common\models\User;

use \common\models\BaseActiveRecord;
use \common\models\User;

/**
 * User approval request
 *
 * @property int    $userId
 * @property string $role
 * @property int    $timeCreated
 * @property int    $timeUpdated
 */
class ApprovalRequest extends BaseActiveRecord
{

    const ROLE_COACH        = 'coach';
    const ROLE_COORDINATOR  = 'coordinator';

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%user_approval_request}}';
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
            'userId'        => \yii::t('app', 'User ID'),
            'role'          => \yii::t('app', 'User role'),
            'timeCreated'   => \yii::t('app', 'Date created'),
        ));
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['userId', 'required'],
            ['role', 'required'],
        ]);
    }

    /**
     * After save action
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // Send an email notification about new approve required
        if ($insert) {
            $user = User::findOne($this->userId);
            if ($user && $user->getApprover()) {
                \yii::$app->cli->runCommand('email', 'coachOrCoordinatorNotify', array(
                    'emailTo'   => $user->getApprover()->email,
                    'userId'    => $user->id,
                ), array(), true);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * Returns whether approval request for recently sent for given user or not
     * @param string $userId
     * @param string $role
     * @return bool
     */
    public static function isSentRecently($userId, $role)
    {
        $count = (int)User\ApprovalRequest::find()
            ->andWhere([
                'userId'    => $userId,
                'role'      => $role,
            ])
            ->andWhere(['>=', 'timeCreated', strtotime('-1 day')])
            ->count()
        ;
        return $count > 0;
    }

}
