<?php

use \common\models\Team;

class TeamCommand extends \console\ext\ConsoleCommand
{

    /**
     * Method which deletes team with specified id
     *
     * @param string $id
     */
    public function actionDelete($id)
    {
        $teamToDelete = Team::model()->findByPk(new \MongoId((string)$id));
        if (isset($teamToDelete)) {
            $teamToDelete->delete();
            echo "Team with id={$id} was successfully deleted\n";
        } else {
            echo "Error! Team with id={$id} was not found\n";
        }
    }

    /**
     * Method which deletes all the teams with isDeleted = true from the data storage
     */
    public function actionRemoveDeleted()
    {
        $teams = Team::model()->findAllByAttributes(array('isDeleted' => true));
        foreach ($teams as $team) {
            $team->delete();
            echo '.';
        }
        echo "\nAll 'deleted' teams have been removed from the data storage.\n";
    }

}
