<?php

class TmpCommand extends \console\ext\ConsoleCommand
{

    /**
     * Set yearCreated attribute for news
     *
     * @version phase-2
     */
    public function actionNewsYearCreated()
    {
        $newsList = \common\models\News::model()->findAll();
        foreach ($newsList as $news) {
            $news->yearCreated = (int)date('Y', $news->dateCreated);
            $news->save();
            echo ".";
        }
        echo "\nDone";
    }

}