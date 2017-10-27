<?php

namespace common\traits;

/**
 * Unique ID for model's form
 * @see Html::getInputId
 */
trait ModelFormIdTrait
{

    /**
     * @var int|string
     */
    private $modelFormId;

    /**
     * Returns unique model's form ID
     * @return int|string
     */
    public function formId()
    {
        if (empty($this->modelFormId)) {
            if (property_exists($this, 'id')) {
                $this->modelFormId = $this->id;
            } else {
                $this->modelFormId = \yii::$app->security->generateRandomString();
            }
        }
        return $this->modelFormId;
    }

}
