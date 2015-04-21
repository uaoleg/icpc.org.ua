<?php

namespace web\modules\staff\controllers;

use \common\components\Rbac;
use \common\models\Geo\State;
use \common\models\User;
use \common\models\ViewTable\Coach as ViewCoach;

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
     * Rebuild view table collection of coaches
     */
    protected function _rebuildViewCollection()
    {
        if (ViewCoach::model()->cache->get('collectionIsUpToDate')) {
            return;
        }

        ViewCoach::model()->getCollection()->remove();

        $criteria = new \EMongoCriteria();
        $criteria->addCond('type', '==', User::ROLE_COACH);
        $list = User::model()->findAll($criteria);

        foreach ($list as $user) {
            $coach = new ViewCoach();
            $coach->setIsNewRecord(true);
            $coach->_id = $user->_id;

            // Save coach
            $coach->setAttributes(array(
                'firstNameUk'  => $user->firstNameUk,
                'middleNameUk' => $user->middleNameUk,
                'lastNameUk'   => $user->lastNameUk,
                'firstNameEn'  => $user->firstNameEn,
                'middleNameEn' => $user->middleNameEn,
                'lastNameEn'   => $user->lastNameEn,
                'email'   => $user->email,
                'isApprovedCoach'=> $user->isApprovedCoach,
                'state'       => $user->school->state,
                'stateName'   => $user->school->getStateLabel(),
            ), false);
            $coach->save();
        }

        ViewCoach::model()->cache->set('collectionIsUpToDate', true, SECONDS_IN_HOUR);
    }

    /**
     * Manage coaches
     */
    public function actionIndex()
    {
        $this->_rebuildViewCollection();
        $states = State::model()->attributeLabels();

        // Render view
        $this->render('index', array(
            'states' => $states['const.name'],
        ));
    }

    /**
     * Method for jqGrid which returns all the coaches
     */
    public function actionGetListJson()
    {
        // Get jqGrid params
        $criteria = new \EMongoCriteria();
        $jqgrid = $this->_getJqgridParams(ViewCoach::model(), $criteria);

        $rows = array();
        foreach ($jqgrid['itemList'] as $user) {
            $arrayToAdd = array(
                'id'              => (string)$user->_id,
                'name'            => \web\widgets\user\Name::create(array('user' => $user, 'lang' => \yii::app()->language), true),
                'email'           => $user->email,
                'dateCreated'     => date('Y-m-d H:i:s', $user->dateCreated),
                'state'           => $user->stateName,
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