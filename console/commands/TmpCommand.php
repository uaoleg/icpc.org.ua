<?php

class TmpCommand extends \console\ext\ConsoleCommand
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
                $school->type = \common\models\School::TYPE_HIGH;
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

}