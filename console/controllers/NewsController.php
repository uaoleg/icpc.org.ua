<?php

namespace console\controllers;

use \common\models\News;

class NewsController extends BaseController
{

    /**
     * Method which deletes news with specified id
     *
     * @param string $id
     */
    public function actionDelete($id)
    {
        $newsToDelete = News::findOne($id);
        if (isset($newsToDelete)) {
            $newsToDelete->delete();
            echo "News with id={$id} was successfully deleted\n";
        } else {
            echo "Error! News with id={$id} was not found\n";
        }
    }

}