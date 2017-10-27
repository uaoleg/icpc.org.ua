<?php

namespace common\rbac;

use \common\models\User;

/**
 * Biz rule for activating/suspending of coordinators
 */
class CoordinatorSetStatusRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $user User */
        $user = $params['user'];

        if ((int)$userId === (int)$user->id) {
            return false;
        } elseif ($user->coordinator === User::ROLE_COORDINATOR_UKRAINE) {
            return \yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_UKRAINE);
        } elseif ($user->coordinator === User::ROLE_COORDINATOR_REGION) {
            return \yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_UKRAINE);
        } elseif ($user->coordinator === User::ROLE_COORDINATOR_STATE) {
            return \yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_REGION);
        } else {
            return false;
        }
    }

}
