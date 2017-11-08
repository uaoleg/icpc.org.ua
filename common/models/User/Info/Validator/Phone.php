<?php

namespace common\models\User\Info\Validator;

use \common\models\User\Info;

class Phone extends \yii\validators\Validator
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Do not skip empty
        $this->skipOnEmpty = false;
    }

    /**
     * Validate phone numbers
     * @param Info      $userInfo
     * @param string    $attribute
     */
    public function validateAttribute($userInfo, $attribute)
    {
        if (empty($userInfo->phoneHome) && empty($userInfo->phoneMobile)) {
            $this->addError($userInfo, $attribute, \yii::t('app', 'Either home or mobile phone must be specified.'));
        }
    }

}