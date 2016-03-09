<?php
namespace common\models\School\Validator;

use \common\models\School;

class Type extends \common\ext\MongoDb\Validator\AbstractValidator
{
    /**
     * Validate type of the school
     * @param School $school
     * @param string $attribute
     */
    public function validateAttribute($school, $attribute)
    {
        if (!$school->attributeHasChanged($attribute)) {
            return;
        }

        if (!in_array($school->$attribute, School::model()->getConstantList('TYPE_'))) {
            $this->addError($school, $attribute, \yii::t('app', 'Unknown type.'));
        }
    }
}