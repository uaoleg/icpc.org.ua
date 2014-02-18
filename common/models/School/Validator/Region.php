<?php
namespace common\models\School\Validator;

use \common\models\School;
use \common\models\Geo;

class Region extends \common\ext\MongoDb\Validator\AbstractValidator
{
    /**
     * Validate region of the school
     * @param School $school
     * @param string $attribute
     */
    public function validateAttribute($school, $attribute)
    {
        if (!$school->attributeHasChanged($attribute)) {
            return;
        }

        if (!in_array($school->$attribute, Geo\Region::model()->getConstantList('NAME_'))) {
            $this->addError($school, $attribute, \yii::t('app', 'Unknown region name.'));
        }
    }
}