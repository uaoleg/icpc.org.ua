<?php

namespace web\modules\staff\controllers;

use \common\models\User;

class CoordinatorsController extends \web\modules\staff\ext\Controller
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
        // Get list of coordinators
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('coordinator', '!=', null)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $userList = User::model()->findAll($criteria);

        // Render view
        $this->render('index', array(
            'userList' => $userList,
        ));
    }

    /**
     * Set coordinator's state
     */
    public function actionSetState()
    {
        // Get params
        $userId = $this->request->getPost('userId');
        $state  = (bool)$this->request->getPost('state', 0);

        // Can't set state for oneself
        if ($userId === \yii::app()->user->getId()) {
            return $this->httpException(403, \yii::t('app', 'Can not set state for oneself.'));
        }

        // Assign coordination role to the user
        if ($state) {

            // Get user
            $user = User::model()->findByPk(new \MongoId($userId));
            if ($user === null) {
                return $this->httpException(404);
            }

            // Assign role
            \yii::app()->authManager->assign($user->coordinator, $userId);
        }

        // Revoke coordination roles
        else {
            \yii::app()->authManager->revoke(User::ROLE_COORDINATOR_STATE, $userId);
            \yii::app()->authManager->revoke(User::ROLE_COORDINATOR_REGION, $userId);
            \yii::app()->authManager->revoke(User::ROLE_COORDINATOR_UKRAINE, $userId);
        }
    }

}