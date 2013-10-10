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

        // Set active main menu item
        $this->setNavActiveItem('main', 'staff');
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

        // Can't set state for oneself
        if ($userId === \yii::app()->user->getId()) {
            return $this->httpException(403, \yii::t('app', 'Can not set state for oneself.'));
        }

        // Assign coordination role to the user
        if ($state) {

            // Get user
            $user = User::model()->findByPk(new \MongoId($userId));

            // Define role
            if ($user->coordinator === User::COORD_UKRAINE) {
                $role = User::ROLE_COORDINATOR_UKRAINE;
            } else {
                $role = User::ROLE_COORDINATOR;
            }

            // Assign role
            \yii::app()->authManager->assign($role, $userId);
        }

        // Revoke coordination roles
        else {
            \yii::app()->authManager->revoke(User::ROLE_COORDINATOR, $userId);
            \yii::app()->authManager->revoke(User::ROLE_COORDINATOR_UKRAINE, $userId);
        }
    }

}