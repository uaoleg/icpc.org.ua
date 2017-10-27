<?php

namespace common\rbac;

use \common\models\Team;

/**
 * Biz rule for edit team
 */
class TeamUpdateRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $team Team */
        $team = $params['team'];

        return ((int)$userId === (int)$team->coachId) && ($team->isOutOfCompetition);
    }

}
