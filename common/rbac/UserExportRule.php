<?php

namespace common\rbac;

use \common\models\User;

/**
 * Export users (csv)
 */
class UserExportRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        return \yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_STATE);
    }

}
