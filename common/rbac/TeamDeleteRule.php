<?php

namespace common\rbac;

use \common\models\Team;

/**
 * Biz rule for deleting team
 */
class TeamDeleteRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $team Team */
        $team = $params['team'];

        return ((int)$userId === (int)$team->coachId);
    }

}
