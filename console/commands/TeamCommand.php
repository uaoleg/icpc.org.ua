<?php

use \common\models\Team;
use \common\models\Result;

class TeamCommand extends \console\ext\ConsoleCommand
{

    /**
     * Method which deletes team with specified id
     * and results for this team
     * @param string $id
     */
    public function actionDelete($id = null)
    {
        if (!isset($id)) {
            echo "\nError! Specify id of team to delete\n";
            exit;
        }
        $teamToDelete = Team::model()->findByPk(new \MongoId((string)$id));
        if (isset($teamToDelete)) {
            $year = $teamToDelete->year;
            $teamToDelete->delete();
            echo "\nTeam with id=\'$id\' was successfully deleted\n";
            $resultsToDelete = Result::model()->findByAttributes(array(
                'teamId' => $id,
                'year'   => $year
            ));
            $resultsToDelete->deleteAll();
            echo "\nResults for that team were successfully deleted\n";
        } else {
            echo "Error! Team with id=$id was not found\n";
        }
    }
}