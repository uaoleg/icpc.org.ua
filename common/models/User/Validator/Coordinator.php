<?php

namespace common\models\User\Validator;

use \common\models\User;

class Coordinator extends \common\ext\MongoDb\Validator\AbstractValidator
{

    /**
     * Validate coordinator attribute
     * @param User   $user
     * @param string $attribute
     */
    public function validateAttribute($user, $attribute)
    {
        if (!$user->attributeHasChanged($attribute)) {
            return;
        }

        if (empty($user->$attribute)) {
            $user->coordinator = null;
        } elseif (!in_array($user->coordinator, $user->getConstantList('ROLE_COORDINATOR_'))) {
            $this->addError($user, $attribute, \yii::t('app', 'Unknown coordinator type.'));
        } elseif ($user->type === User::ROLE_STUDENT) {
            $this->addError($user, $attribute, \yii::t('app', 'Student cannot be coordinator.'));
        }
    }
} 