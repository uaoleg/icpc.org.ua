<?php

namespace common\behaviors;

use \common\models\BaseActiveRecord;
use \yii\base\Event;
use \yii\behaviors\AttributeBehavior;

class DateTimeFormatBehavior extends AttributeBehavior
{

    /**
     * Datetime DB format
     * @var string
     */
    public $dbFormat;

    /**
     * Datetime view format
     * @var string
     */
    public $viewFormat;

    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT   => 'formatDb',
            BaseActiveRecord::EVENT_BEFORE_UPDATE   => 'formatDb',
            BaseActiveRecord::EVENT_AFTER_INSERT    => 'formatView',
            BaseActiveRecord::EVENT_AFTER_UPDATE    => 'formatView',
            BaseActiveRecord::EVENT_AFTER_FIND      => 'formatView',
        ];
    }

    /**
     * DB date format
     * @param Event $event
     */
    public function formatDb(Event $event)
    {
        foreach ($this->attributes as $attribute) {
            $this->formatDate($event->sender, $attribute, $this->dbFormat);
        }
    }

    /**
     * View date format
     * @param Event $event
     */
    public function formatView(Event $event)
    {
        foreach ($this->attributes as $attribute) {
            $this->formatDate($event->sender, $attribute, $this->viewFormat);
        }
    }

    /**
     * Formats date for given attribute name
     * @param BaseActiveRecord $model
     * @param string $attr
     * @param string $format
     */
    protected function formatDate(BaseActiveRecord $model, $attr, $format)
    {
        // Skip for empty value
        if (!$model->$attr) {
            return;
        }

        // Prevent time zone converting
        $f = \yii::$app->formatter;
        $timeZone = $f->timeZone;
        $f->timeZone = 'UTC';

        // Format
        try {
            $model->$attr = $f->asDate($model->$attr, $format);
        }

        // If invalid date than add error
        catch (\yii\base\InvalidParamException $ex) {
            $model->addError($attr, \yii::t('app', $ex->getMessage()));
        }

        // Restore time zone
        $f->timeZone = $timeZone;
    }

}
