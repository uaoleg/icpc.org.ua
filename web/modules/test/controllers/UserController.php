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
        $email = \yii::app()->request->getDelete('email');

        // Check length
        if (mb_strlen($email) < 3) {
            echo \yii::t('app', 'Email length should be 3 symbols or more.');
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