<?php

namespace common\ext\Mail;

\yii::import('common.lib.YiiMail.YiiMail');

class Mail extends \YiiMail
{

    /**
     * Path to the message layout file
     * @var string
     */
    public $layoutPath;

    /**
     * Check if given email is unsubscribed
     *
     * @param string $email
     * @return bool
     */
    public function isUnsubscribed($email)
    {
        $count = \common\models\Unsubscribed::model()->countByAttributes(array(
            'email' => mb_strtolower($email),
        ));
        return ($count > 0);
    }

}