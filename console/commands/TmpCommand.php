<?php

class TmpCommand extends \console\ext\ConsoleCommand
{

    /**
     * Activate all existing students
     *
     * @version 2.2
     */
    public function actionActivateStudents()
    {
        $users = \common\models\User::model()->findAllByAttributes(array(
            'type' => \common\models\User::ROLE_STUDENT
        ));
        foreach ($users as $user) {
            echo '.';
            if (!\yii::app()->authManager->checkAccess(\common\models\User::ROLE_STUDENT, $user->_id)) {
                \yii::app()->authManager->assign(\common\models\User::ROLE_STUDENT, $user->_id);
            }
        }
        echo "\nDone";
    }

}