<?php
namespace common\models\User\InfoAbstract\Validator;

use \common\models\User;
use \common\models\User\InfoAbstract;

class Phone extends \common\ext\MongoDb\Validator\AbstractValidator
{
    /**
     * Validate role assigned to user
     * @param InfoAbstract $userInfo
     * @param string       $attribute
     */
    public function validateAttribute($userInfo, $attribute)
    {
        if (empty($userInfo->phoneHome) && empty($userInfo->phoneMobile)) {
            $this->addError($userInfo, $attribute, \yii::t('app', 'Either home or phone mobile must be specified'));
            $this->addError($userInfo, 'phoneHome', \yii::t('app', 'Either home or phone mobile must be specified'));
            $this->addError($userInfo, 'phoneMobile', \yii::t('app', 'Either home or phone mobile must be specified'));
        }
    }
}