<?php
namespace common\models\User\Info\Validator;

use \common\models\User\Info;

class Phone extends \common\ext\MongoDb\Validator\AbstractValidator
{

    /**
     * Validate role assigned to user
     *
     * @param Info      $userInfo
     * @param string    $attribute
     */
    public function validateAttribute($userInfo, $attribute)
    {
        if (empty($userInfo->phoneHome) && empty($userInfo->phoneMobile)) {
            $errorMessage = \yii::t('app', 'Either home or mobile phone must be specified.');
            $this->addError($userInfo, $attribute, $errorMessage);
            $this->addError($userInfo, 'phoneHome', $errorMessage);
            $this->addError($userInfo, 'phoneMobile', $errorMessage);
        }
    }

}