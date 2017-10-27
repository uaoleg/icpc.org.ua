<?php

namespace console\controllers;

class TmpController extends BaseController
{

    /**
     * Convert dates of birth to timestamps for all users
     *
     * @version 3.1
     */
    public function actionConvertBirthDates()
    {
        $users = \common\models\User::model()->findAll();

        foreach ($users as $user) {
            echo '.';
            if (is_string($user->info->dateOfBirth)) {
                $user->info->dateOfBirth = strtotime($user->info->dateOfBirth);
            }
            if ($user->info->dateOfBirth === false) {
                $user->info->dateOfBirth = null;
            }
            $user->info->save(false);
        }

        echo "\nDone";
    }

    /**
     * Set isOutOfCompetition to false to all existing teams
     *
     * @version 3.2
     */
    public function actionSetOutOfCompetitionTeamProperty()
    {
        $teams = \common\models\Team::model()->findAll();

        foreach ($teams as $team) {
            echo '.';
            $team->isOutOfCompetition = false;
            $team->save();
        }

        echo "\nDone";
    }

    /**
     * Set default schoool type
     *
     * @version 16.1
     */
    public function actionSchoolType()
    {
        echo "Default school type";
        $schools = \common\models\School::model()->findAll();
        foreach ($schools as $school) {
            if (empty($school->type)) {
                if (mb_strpos($school->fullNameUk, 'Поза конкурсом - ') === 0) {
                    $school->type = \common\models\School::TYPE_MIDDLE;
                } else {
                    $school->type = \common\models\School::TYPE_HIGH;
                }
                $school->save();
            }
            echo '.';
        }
        echo "\n";

        echo "Team school type";
        $teams = \common\models\Team::model()->findAll();
        foreach ($teams as $team) {
            if (empty($team->schoolType) && $team->school) {
                $team->schoolType = $team->school->type;
                $team->save();
            }
            echo '.';
        }
        echo "\n";

        echo "Result school type";
        $results = \common\models\Result::model()->findAll();
        foreach ($results as $result) {
            if (empty($result->schoolType) && $result->team && $result->team->school) {
                $result->schoolType = $result->team->school->type;
                $result->save();
            }
            echo '.';
        }
        echo "\n";

        echo "\nDone";
    }

    /**
     * Apply new region
     *
     * @version 16.1
     */
    public function actionNewRegion()
    {
        echo "Schools";
        $schools = \common\models\School::model()->findAll();
        foreach ($schools as $school) {
            $stateModel = new \common\models\Geo\State();
            $stateModel->name = $school->state;
            $school->region = $stateModel->getRegion()->name;
            $school->save();
            echo '.';
        }
        echo "\n";

        echo "Teams";
        $teams = \common\models\Team::model()->findAll();
        foreach ($teams as $team) {
            $stateModel = new \common\models\Geo\State();
            $stateModel->name = $team->state;
            $initLang = \yii::$app->language;
            foreach (\yii::$app->params['languages'] as $language => $label) {
                \yii::$app->language = $language;
                $team->state[$language] = $team->school->getStateLabel();
                $team->region[$language] = $team->school->getRegionLabel();
            }
            \yii::$app->language = $initLang;
            $team->save();
            echo '.';
        }
        echo "\n";

        echo "\nDone";
    }

}