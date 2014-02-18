<?php
namespace web\modules\staff\controllers;

use \common\models\User;
use \common\components\Rbac;

class StudentsController extends \web\modules\staff\ext\Controller
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
     * Manage students
     */
    public function actionIndex()
    {
        // Get list of coaches
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('type', '==', User::ROLE_STUDENT)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $userList = User::model()->findAll($criteria);

        // Render view
        $this->render('index', array(
            'userList' => $userList,
        ));
    }

    /**
     * Set student's state
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
        if (!\yii::app()->user->checkAccess(Rbac::OP_STUDENT_SET_STATUS)) {
            return $this->httpException(403);
        }

        // Assign coach role to the user
        if ($state) {
            \yii::app()->authManager->assign(User::ROLE_STUDENT, $userId);
        }

        // Revoke coordination roles
        else {
            \yii::app()->authManager->revoke(User::ROLE_STUDENT, $userId);
        }
    }

}