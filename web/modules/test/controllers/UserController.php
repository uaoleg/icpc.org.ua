<?php

namespace web\modules\test\controllers;

use \common\models\User;

class UserController extends \web\modules\test\ext\Controller
{

    /**
     * Delete users
     */
    public function actionDelete()
    {
        // Get params
        $email      = \yii::app()->request->getDelete('email');
        $minLength  = 3;

        // Check length
        if (mb_strlen($email) < $minLength) {
            echo \yii::t('app', 'Email length should be {n} symbols or more.', $minLength);
            return;
        }

        // Delete users
        $criteria = new \EMongoCriteria();
        $criteria->addCond('email', '==', new \MongoRegex('/^'.preg_quote($email).'/i'));
        $users = User::model()->findAll($criteria);
        foreach ($users as $user) {
            echo "{$user->email}<br />";
            $user->delete();
        }
    }

}