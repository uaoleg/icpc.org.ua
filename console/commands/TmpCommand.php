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

    /**
     * Set geo attribute for news
     *
     * @version phase-2
     */
    public function actionNewsGeo()
    {
        $modifier = new \EMongoModifier();
        $modifier->addModifier('geo', 'set', \common\models\School::model()->country);
        \common\models\News::model()->updateAll($modifier);
    }

}