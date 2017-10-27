<?php

namespace common\behaviors;

use \common\models\BaseActiveRecord;
use \yii\base\Event;
use \yii\behaviors\AttributeBehavior;
use \yii\helpers\Json;

/**
 * JSON encode/decode of attribute value
 */
class JsonBehavior extends AttributeBehavior
{

    /**
     * Declares event handlers for the [[owner]]'s events.
     * @return array
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT   => 'jsonEncode',
            BaseActiveRecord::EVENT_BEFORE_UPDATE   => 'jsonEncode',
            BaseActiveRecord::EVENT_AFTER_INSERT    => 'jsonDecode',
            BaseActiveRecord::EVENT_AFTER_UPDATE    => 'jsonDecode',
            BaseActiveRecord::EVENT_AFTER_FIND      => 'jsonDecode',
        ];
    }

    /**
     * Encode attribute value
     * @param Event $event
     */
    public function jsonEncode(Event $event)
    {
        foreach ($this->attributes as $attribute) {
            $value = $event->sender->$attribute;
            if (is_array($value) || is_object($value)) {
                $event->sender->$attribute = Json::encode($value);
            }
        }
    }

    /**
     * Decode attribute value
     * @param Event $event
     */
    public function jsonDecode(Event $event)
    {
        foreach ($this->attributes as $attribute) {
            $value = $event->sender->$attribute;
            try {
                $json = Json::decode($value);
            } catch (\yii\base\InvalidParamException $e) {
                $json = $value;
            }
            if ($json !== null) {
                $event->sender->$attribute = $json;
            }
        }
    }

}
