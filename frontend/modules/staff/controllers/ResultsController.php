<?php

namespace frontend\modules\staff\controllers;

use \common\components\Rbac;
use \common\models\Result;

class ResultsController extends \frontend\modules\staff\ext\Controller
{

    /**
     * All the rules of access to methods of this controller
     * @return array
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('teamdelete'),
                'roles' => array(Rbac::OP_RESULT_TEAM_DELETE),
            ),
            array(
                'allow',
                'actions' => array('prizeplaceupdate'),
                'roles' => array(Rbac::OP_RESULT_CREATE),
            ),
            array(
                'deny',
            )
        );
    }

    /**
     * Remove team from results
     */
    public function actionTeamDelete($id)
    {
        // Get result of the team
        $result = Result::findOne($id);

        // Delete result
        if ($result !== null) {
            $result->delete();
        }
    }

    /**
     * Update prize place
     */
    public function actionPrizePlaceUpdate()
    {
        // Get params
        $id         = \yii::$app->request->get('id');
        $prizePlace = \yii::$app->request->get('prizePlace');

        // Get result
        $result = Result::findOne($id);
        if ($result === null) {
            return;
        }

        // Update phase
        $result->prizePlace = (int)$prizePlace;
        if ($result->validate(array('prizePlace'))) {
            $result->save(false);
        }
    }

}