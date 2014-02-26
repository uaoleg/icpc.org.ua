<?php

class TmpCommand extends \console\ext\ConsoleCommand
{

    /**
     * Update teams' state and region
     *
     * @version 2.1
     */
    public function actionTeamStateRegion()
    {
        $teams = \common\models\Team::model()->findAll();
        foreach ($teams as $team) {
            echo ".";
            foreach (\yii::app()->params['languages'] as $language => $label) {
                \yii::app()->language = $language;
                $team->state[$language] = $team->school->getStateLabel();
                $team->region[$language] = $team->school->getRegionLabel();
            }
            $team->save(false);
        }
        echo "\nDone";
    }

    /**
     * Update teams' placeText
     *
     * @version 2.1
     */
    public function actionResultPlaceText()
    {
        $results = \common\models\Result::model()->findAllByAttributes(array(
            'placeText' => array('$exists' => false),
        ));
        foreach ($results as $result) {
            echo '.';
            $result->placeText = (string)$result->place;
            $result->save(false);
        }
        echo "\nDone";
    }

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