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
        // Render view
        $this->render('index');
    }

    /**
     * Method for jqGrid which returns all the coaches
     */
    public function actionGetListJson()
    {
        // Get jqGrid params
        $criteria = new \EMongoCriteria();
        $criteria->addCond('type', '==', User::ROLE_COACH);
        $jqgrid = $this->_getJqgridParams(User::model(), $criteria);

        $rows = array();
        foreach ($jqgrid['itemList'] as $user) {
            $arrayToAdd = array(
                'id'              => (string)$user->_id,
                'name'            => \web\widgets\user\Name::create(array('user' => $user, 'lang' => \yii::app()->language), true),
                'email'           => $user->email,
                'dateCreated'     => date('Y-m-d H:i:s', $user->dateCreated),
                'isApprovedCoach' => $this->renderPartial('index/action', array('user' => $user), true)
            );
            $rows[] = $arrayToAdd;
        }

        $this->renderJson(array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
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