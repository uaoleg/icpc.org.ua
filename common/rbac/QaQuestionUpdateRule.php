<?php

namespace common\rbac;

use \common\models\Qa\Question;

/**
 * Biz rule for question update
 */
class QaQuestionUpdateRule extends BaseRule
{

    /**
     * @inheritdoc
     */
    public function execute($userId, $item, $params)
    {
        /* @var $question Question */
        $question = $params['question'];

        return (int)$userId === (int)$question->userId;
    }

}
