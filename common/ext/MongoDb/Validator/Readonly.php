<?php

namespace common\ext\MongoDb\Validator;

class Readonly extends AbstractValidator
{

    /**
     * Validate object property not to be changed
     *
     * @param \common\ext\MongoDb\Document $object
     * @param string $attribute
     */
	public function validateAttribute($object, $attribute)
	{
        if ($object->attributeHasChanged($attribute)) {
            $this->addError($object, $attribute, \yii::t('app', '{attribute} has changed.'));
        }
	}

}