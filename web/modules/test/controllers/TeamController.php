<?php
namespace web\modules\test\controllers;

use web\modules\test\ext\Controller;

class TeamController extends Controller
{
	
	/**
	 * Delete all the teams with isDeleted = true from the data storage
	 */
    public function actionDelete()
    {
        \yii::app()->cli->runCommand('team', 'removeDeleted');
        echo "Removed deleted teams from data storage";
    }
	
}