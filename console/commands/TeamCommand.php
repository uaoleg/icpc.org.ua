<?php

use \common\models\Team;
use \common\models\Result;

class TeamCommand extends \console\ext\ConsoleCommand
{

    /**
     * Method which deletes team with specified id and results for this team
     *
     * @param string $id
     */
    public function actionDelete($id)
    {
        $teamToDelete = Team::model()->findByPk(new \MongoId((string)$id));
        if (isset($teamToDelete)) {
            $year = $teamToDelete->year;
            $teamToDelete->delete();
            echo "Team with id={$id} was successfully deleted\n";
            $criteria = new EMongoCriteria();
            $criteria
                ->addCond('teamId', '==', $id)
                ->addCond('year', '==', (int)$year);
            Result::model()->deleteAll($criteria);
            echo "Results for that team were successfully deleted\n";
        } else {
            echo "Error! Team with id={$id} was not found\n";
        }
    }
}