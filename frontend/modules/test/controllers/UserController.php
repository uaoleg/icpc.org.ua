<?php

namespace frontend\modules\test\controllers;

use \common\models\User;

class UserController extends \frontend\modules\test\ext\Controller
{

    /**
     * Delete users
     */
    public function actionDelete()
    {
        // Get params
        $email      = \yii::$app->request->post('email');
        $minLength  = 3;

        // Check length
        if (mb_strlen($email) < $minLength) {
            echo \yii::t('app', 'Email length should be {0} symbols or more.', $minLength);
            return;
        }

        // Delete users
        $users = User::findAll(['LIKE', 'email', $email]);
        foreach ($users as $user) {
            echo "{$user->email}<br />";
            $user->delete();
        }
    }

}