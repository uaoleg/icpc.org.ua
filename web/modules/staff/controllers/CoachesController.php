<?php

namespace web\modules\staff\controllers;

use \common\components\Rbac;
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

        // Get user
        $user = User::model()->findByPk(new \MongoId($userId));
        if ($user === null) {
            return $this->httpException(404);
        }

        // Check access
        if (!\yii::app()->user->checkAccess(Rbac::OP_COACH_SET_STATUS, array('user' => $user))) {
            return $this->httpException(403);
        }

        // Assign coach role to the user
        if ($state) {
            $user->isApprovedCoach = true;
        }

        // Revoke coordination roles
        else {
            $user->isApprovedCoach = false;
        }

        $user->save();
    }

}