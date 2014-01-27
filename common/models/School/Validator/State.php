<?php
namespace common\models\School\Validator;

use \common\models\School;
use \common\models\Geo;

class State extends \common\ext\MongoDb\Validator\AbstractValidator
{
    /**
     * Validate state of the school
     * @param School $school
     * @param string $attribute
     */
    public function validateAttribute($school, $attribute)
    {
        if (!$school->attributeHasChanged($attribute)) {
            return;
        }

        if (!in_array($school->$attribute, Geo\State::model()->getConstantList('NAME_'))) {
            $this->addError($school, $attribute, \yii::t('app', 'Unknown state name.'));
        }
    }
}