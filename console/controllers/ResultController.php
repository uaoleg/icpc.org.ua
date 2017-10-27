<?php

namespace console\controllers;

use \common\models\Result;

class ResultController extends BaseController
{

    /**
     * Method which deletes results for specified year and geo info
     *
     * @param int    $year
     * @param string $geo
     */
    public function actionDelete($year, $geo)
    {
        if (isset($year) && isset($geo)) {
            Result::deleteAll([
                'year'  => (int)$year,
                'geo'   => $geo,
            ]);
            echo "Results for year {$year} and geo = {$geo} were successfully deleted\n";
        } else {
            echo "Error! Specify year and geo of results to delete\n";
        }
    }
}