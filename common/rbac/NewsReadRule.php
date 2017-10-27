<?php

namespace common\rbac;

use \common\models\News;

/**
 * Biz rule for reading news
 */
class NewsReadRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $news News */
        $news = $params['news'];

        if ($news->isPublished) {
            return true;
        } else {
            return \yii::$app->authManager->checkAccess($userId, \common\components\Rbac::OP_NEWS_UPDATE, $params);
        }
    }

}
