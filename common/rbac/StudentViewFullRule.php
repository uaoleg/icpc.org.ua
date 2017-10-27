<?php

namespace common\rbac;

use \common\models\User;

/**
 * Biz rule to view student's full profile
 */
class StudentViewFullRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $user User */
        $user = $params['user'];

        if ($user->type !== User::ROLE_STUDENT) {
            return false;
        } elseif (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_STATE)) {
            return true;
        } else {
            $me = User::findOne($userId);
            return $me && ($me->schoolId === $user->schoolId);
        }
    }

}
