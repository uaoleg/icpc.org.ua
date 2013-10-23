<?php

namespace web\modules\staff\controllers;

use \common\models\User;

class CoachesController extends \web\modules\staff\ext\Controller
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
     * Manage coaches
     */
    public function actionIndex()
    {
        // Get list of coaches
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('type', '==', User::ROLE_COACH)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $userList = User::model()->findAll($criteria);

        // Render view
        $this->render('index', array(
            'userList' => $userList,
        ));
    }

    /**
     * Set coach's state
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

        // Assign coach role to the user
        if ($state) {
            \yii::app()->authManager->assign(User::ROLE_COACH, $userId);
        }

        // Revoke coordination roles
        else {
            \yii::app()->authManager->revoke(User::ROLE_COACH, $userId);
        }
    }

}