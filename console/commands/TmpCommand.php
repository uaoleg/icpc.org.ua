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

    /**
     * Set isDeleted = false for all teams
     * @version 2.2
     */
    public function actionSetTeamsNotDeleted()
    {
        $modifier = new \EMongoModifier();
        $modifier->addModifier('isDeleted', 'set', false);
        \common\models\Team::model()->updateAll($modifier);
        echo "\nDone";
    }

}