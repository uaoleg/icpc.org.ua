<?php

namespace web\helpers;

class User
{
    public function resetPwdAndLogin(
        \common\models\User $user,
        \common\models\User\PasswordReset $token,
        $password,
        $passwordRepeat
    )
    {
        $user->setPassword($password, $passwordRepeat);
        if (!$user->hasErrors()) {
            $user->save();
            $this->authenticate($user->email, $password);
            $token->delete();
        }
    }
    
    public function authenticate($email, $password)
    {
        $identity = new \web\ext\UserIdentity($email, $password);
        $identity->authenticate();
        return \yii::app()->user->login($identity);
    }
}
