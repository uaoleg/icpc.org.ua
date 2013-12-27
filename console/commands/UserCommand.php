<?php

use \common\models\User;

class UserCommand extends \console\ext\ConsoleCommand
{

    /**
     * Method which deletes user with specified id
     *
     * @param string $id
     */
    public function actionDelete($id)
    {
        $userToDelete = User::model()->findByPk(new \MongoId((string)$id));
        if (isset($userToDelete)) {
            $userToDelete->delete();
            echo "User with id={$id} was successfully deleted\n";
        } else {
            echo "Error! User with id={$id} was not found\n";
        }
    }

}
