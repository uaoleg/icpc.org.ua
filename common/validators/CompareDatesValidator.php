<?php

namespace common\validators;

use \yii\validators\CompareValidator;

class CompareDatesValidator extends CompareValidator
{

    /**
     * Validate only if date has been changed
     * @var bool
     */
    public $onlyChanged = null;

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default
        if ($this->onlyChanged === null) {

            // Always compare attributes
            if ($this->compareAttribute) {
                $this->onlyChanged = false;
            }

            // Compare with values only if changed
            else {
                $this->onlyChanged = true;
            }
        }
    }

    /**
     * Validates a single attribute
     * @param \yii\base\Model $model the data model to be validated
     * @param string $attribute the name of the attribute to be validated.
     */
    public function validateAttribute($model, $attribute)
    {
        // Validate only if date has been changed
        if ($this->onlyChanged && !empty($model->getOldAttribute($attribute))) {
            $oldValue = \yii::$app->formatter->asDate($model->getOldAttribute($attribute));
            $newValue = $model->$attribute;
            if ($this->compareValues('===', 'string', $oldValue, $newValue)) {
                return;
            }
        }

        parent::validateAttribute($model, $attribute);
    }

    /**
     * Compares two values with the specified operator.
     * @param string $operator the comparison operator
     * @param string $type the type of the values being compared
     * @param mixed $value the value being compared
     * @param mixed $compareValue another value being compared
     * @return boolean whether the comparison using the specified operator is true.
     */
    protected function compareValues($operator, $type, $value, $compareValue)
    {
        $value = \yii::$app->formatter->asTimestamp($value);
        $compareValue = \yii::$app->formatter->asTimestamp($compareValue);
        return parent::compareValues($operator, $type, $value, $compareValue);
    }

    /**
     * @inheritdoc
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        /** @todo Implement client validation */
    }

}
