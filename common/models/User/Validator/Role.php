<?php
namespace common\models\User\Validator;

use \common\models\User;

class Role extends \common\ext\MongoDb\Validator\AbstractValidator
{
    public function validateAttribute($user, $attribute)
    {
        if ((empty($user->type)) && (empty($user->coordinator))) {
            $this->addError($user, 'role', \yii::t('app', 'User should have some role.'));
        }
    }
}