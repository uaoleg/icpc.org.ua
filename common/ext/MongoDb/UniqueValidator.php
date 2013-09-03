<?php

namespace common\ext\MongoDb;

\yii::import('common.lib.YiiMongoDbSuite.extra.EMongoUniqueValidator', true);

class UniqueValidator extends \EMongoUniqueValidator
{

    /**
     * Validate object property to be unique
     *
     * @param \common\ext\MongoDb\Document $object
     * @param string $attribute
     */
	public function validateAttribute($object, $attribute)
	{
        // Get property value
		$value = $object->{$attribute};

        // If it's empty
		if (($this->allowEmpty) && (($value === null) || ($value === ''))) {
			return;
        }

        // Find duplicates
		$criteria = new \EMongoCriteria();
        $criteria->addCond($attribute, '==', new \MongoRegex('/^'.preg_quote($value).'$/i'));
        if ($object->_id !== null) {
            $criteria->addCond('_id', '!=', $object->_id);
        }
		$count = $object->model()->count($criteria);

        // If there are duplicates
		if ($count !== 0)
			$this->addError(
				$object,
				$attribute,
				\yii::t('app', '{attribute} is not unique in DB.')
			);
	}

}