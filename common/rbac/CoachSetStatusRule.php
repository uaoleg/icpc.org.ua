<?php

namespace common\rbac;

use \common\models\User;

/**
 * Biz rule for activating/suspending of coach
 */
class CoachSetStatusRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $user User */
        $user = $params['user'];
        $me = User::findOne($userId);

        if (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_UKRAINE)) {
            return true;
        } elseif (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_REGION)) {
            return $me->school->region === $user->school->region;
        } elseif (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_STATE)) {
            return $me->school->state === $user->school->state;
        } else {
            return false;
        }
    }

}
