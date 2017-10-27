<?php

namespace common\components;

class LogSentryTarget extends \notamedia\sentry\SentryTarget
{

    /**
     * Limit of messages to send per day
     * @var int
     */
    public $dailyLimit;

    /**
     * @inheritdoc
     */
    public function export()
    {
        // Check daily limit
        if ($this->dailyLimit) {
            $cacheKey = static::class . '\count';
            $countSent = (int)\yii::$app->cache->get($cacheKey);
            $countSent += count($this->messages);
            \yii::$app->cache->set($cacheKey, $countSent);
            if ($countSent > $this->dailyLimit) {
                return;
            }
        }

        // Export messages
        parent::export();
    }

}
