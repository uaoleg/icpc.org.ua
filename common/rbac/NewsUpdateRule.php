<?php

namespace common\rbac;

use \common\models\Geo;
use \common\models\News;
use \common\models\User;

/**
 * Biz rule for edit news
 */
class NewsUpdateRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $news News */
        $news = $params['news'];
        $geo = $news->geo;
        $me = User::findOne($userId);

        // Any news
        if (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_UKRAINE)) {
            return true;
        }

        // Region news
        elseif (in_array($geo, Geo\Region::getConstants('NAME_'))) {
            return ($me && ($geo === $me->school->region) && (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_REGION)));
        }

        // State news
        elseif (in_array($geo, Geo\State::getConstants('NAME_'))) {
            $region = Geo\State::get($geo)->region->name;
            $stateMatch = ($me && ($geo === $me->school->state) && (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_STATE)));
            $regionMatch = ($me && ($region === $me->school->region) && (\yii::$app->authManager->checkAccess($userId, User::ROLE_COORDINATOR_REGION)));
            return (($stateMatch) || ($regionMatch));
        }

        // Failed
        else {
            return false;
        }
    }

}
