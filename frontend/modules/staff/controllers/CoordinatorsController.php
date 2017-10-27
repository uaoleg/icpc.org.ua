<?php

namespace frontend\modules\staff\controllers;

use \common\components\Rbac;
use \common\models\User;
use \frontend\modules\staff\search\CoordinatorSearch;

class CoordinatorsController extends \frontend\modules\staff\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set active main menu item
        $this->setNavActiveItem('main', 'users');
    }

    /**
     * Manage coordinators
     */
    public function actionIndex()
    {
        // Get list of coordiantors
        $search = new CoordinatorSearch;
        $provider = $search->search(\yii::$app->request->queryParams);

        // Render view
        return $this->render('index', array(
            'provider'  => $provider,
            'search'    => $search,
        ));
    }

    /**
     * Set coordinator's state
     */
    public function actionSetState()
    {
        // Get params
        $userId = \yii::$app->request->post('userId');
        $state  = (bool)\yii::$app->request->post('state', 0);

        // Get user
        $user = User::findOne($userId);
        if ($user === null) {
            return $this->httpException(404);
        }

        // Check access
        if (!\yii::$app->user->can(Rbac::OP_COORDINATOR_SET_STATUS, array('user' => $user))) {
            return $this->httpException(403);
        }

        // Assign coordination role to the user
        if ($state) {
            $user->isApprovedCoordinator = true;
        }

        // Revoke coordination roles
        else {
            $user->isApprovedCoordinator = false;
        }

        $user->save();
    }

    /**
     * Deactivate coach's state
     */
    public function actionDeactivateAll()
    {
        // Check access
        if (!\yii::$app->user->can(User::ROLE_COORDINATOR_UKRAINE, array('user' => \yii::$app->user->identity))) {
            return $this->httpException(403);
        }

        // Deactivate
        User::updateAll([
            'isApprovedCoordinator' => false,
        ], [
            '!=', 'id', \yii::$app->user->id,
        ]);

        // Redirect to edit page
        $this->redirect(array('index'));
    }

}