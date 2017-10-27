<?php

namespace common\rbac;

use \common\models\Team;
use \common\models\User;

/**
 * Export team's form (html)
 */
class TeamExportOneRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $team Team */
        $team = $params['team'];

        if ((int)$userId === (int)$team->coachId) {
            return true;
        } else {
            return \yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_STATE);
        }
    }

}
