<?php

namespace frontend\components\exceptions;

class PasswordResetTokenException extends \yii\web\HttpException
{

    /**
     * Constructor.
     * @param string $message error message
     * @param integer $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(400, \yii::t('app', 'Ссылка для восстановления пароля похоже устарела'), $code, $previous);
    }

}
