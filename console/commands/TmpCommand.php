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

}