<?php

namespace common\rbac;

use \common\models\User;

/**
 * Biz rule to update team's league
 */
class TeamLeagueUpdateRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        return \yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_STATE);
    }

}
