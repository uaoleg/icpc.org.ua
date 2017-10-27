<?php

namespace console\controllers;

use \common\models\User;

class UserController extends BaseController
{

    /**
     * Method which deletes user with specified id
     *
     * @param string $id
     */
    public function actionDelete($id)
    {
        $userToDelete = User::findOne($id);
        if (isset($userToDelete)) {
            $userToDelete->delete();
            echo "User with id={$id} was successfully deleted\n";
        } else {
            echo "Error! User with id={$id} was not found\n";
        }
    }

}
