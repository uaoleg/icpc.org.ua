<?php

namespace web\modules\staff\controllers;

use \common\models\User;

class IndexController extends \web\modules\staff\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'coordinator';
    }

    /**
     * Manage coordinators
     */
    public function actionCoordinator()
    {
        // Get list of coordinators
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('coordinator', '!=', null)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $userList = User::model()->findAll($criteria);

        // Render view
        $this->render('coordinator', array(
            'userList' => $userList,
        ));
    }

    /**
     * Set coordinator's state
     */
    public function actionCoordinatorSetState()
    {
        // Get params
        $userId = $this->request->getPost('userId');
        $state  = (bool)$this->request->getPost('state', 0);

        // Assign coordination role to a given user
        if ($state) {
            \yii::app()->authManager->assign(User::ROLE_COORDINATOR, $userId);
        }

        // Revoke coordination role
        else {
            \yii::app()->authManager->revoke(User::ROLE_COORDINATOR, $userId);
        }
    }

}