<?php

use \common\models\Result;

class ResultsCommand extends \console\ext\ConsoleCommand
{

    /**
     * Method which deletes results for specified year and geo info
     * @param int    $year
     * @param string $geo
     */
    public function actionDelete($year = null, $geo = null)
    {
        if (isset($year) && isset($geo)) {
            $criteria = new \EMongoCriteria();
            $criteria
                ->addCond('year', '==', (int)$year)
                ->addCond('geo', '==', $geo);
            Result::model()->deleteAll($criteria);
            echo "\nResults for year $year and geo = $geo were successfully deleted\n";
        } else {
            echo "\nError! Specify year and geo of results to delete\n";
        }
    }
}