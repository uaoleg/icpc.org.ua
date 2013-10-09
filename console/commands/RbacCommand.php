<?php

use \common\ext\MongoDb\Auth,
    \common\models\User;

class RbacCommand extends \console\ext\ConsoleCommand
{

    /**
     * Auth manager
     * @var \common\ext\MongoDb\Auth\Manager
     */
    public $auth;

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        $this->auth = \yii::app()->authManager;
    }

    /**
     * Init RBAC roles, tasks and operations
     */
    public function actionInit()
    {
        /**
         * Delete operations and tasks
         */
        $criteria = new \EMongoCriteria();
        $criteria->addCond('type', 'in', array(\CAuthItem::TYPE_OPERATION, \CAuthItem::TYPE_TASK));
        Auth\Item::model()->deleteAll($criteria);
        $this->auth->init();

        /**
         * Create operations
         */
        $this->_operationsDocument();
        $this->_operationsNews();

        /**
         * Guest role
         */
        $guest = $this->auth->getAuthItem(User::ROLE_GUEST);
        if (!$guest) {
            $guest = $this->auth->createRole(User::ROLE_GUEST);
        }
        $guestOperationList = array(
            'documentRead',
            'newsRead',
        );
        foreach ($guestOperationList as $guestOperation) {
            if (!$guest->hasChild($guestOperation)) {
                $guest->addChild($guestOperation);
            }
        }

        /**
         * Student role
         */
        $student = $this->auth->getAuthItem(User::ROLE_STUDENT);
        if (!$student) {
            $student = $this->auth->createRole(User::ROLE_STUDENT);
        }
        if (!$student->hasChild(User::ROLE_GUEST)) {
            $student->addChild(User::ROLE_GUEST);
        }

        /**
         * Coach role
         */
        $coach = $this->auth->getAuthItem(User::ROLE_COACH);
        if (!$coach) {
            $coach = $this->auth->createRole(User::ROLE_COACH);
        }
        if (!$coach->hasChild(User::ROLE_STUDENT)) {
            $coach->addChild(User::ROLE_STUDENT);
        }

        /**
         * Coordinator role
         */
        $coordinator = $this->auth->getAuthItem(User::ROLE_COORDINATOR);
        if (!$coordinator) {
            $coordinator = $this->auth->createRole(User::ROLE_COORDINATOR);
        }
        if (!$coordinator->hasChild(User::ROLE_STUDENT)) {
            $coordinator->addChild(User::ROLE_STUDENT);
        }

        /**
         * Admin role
         */
        $admin = $this->auth->getAuthItem(User::ROLE_ADMIN);
        if (!$admin) {
            $admin = $this->auth->createRole(User::ROLE_ADMIN);
        }
        $adminOperationList = array(
            User::ROLE_COORDINATOR,
            'documentCreate',
            'documentUpdate',
            'newsCreate',
            'newsUpdate',
        );
        foreach ($adminOperationList as $adminOperation) {
            if (!$admin->hasChild($adminOperation)) {
                $admin->addChild($adminOperation);
            }
        }

        echo "RBAC inited succesfully.";
    }

    /**
     * Document operations
     */
    protected function _operationsDocument()
    {
        $bizRuleRead   = 'return \yii::app()->rbac->bizRuleDocumentRead($params);';
        $bizRuleUpdate = 'return \yii::app()->rbac->bizRuleDocumentUpdate($params);';

        $this->auth->createOperation('documentCreate', 'Create document');
        $this->auth->createOperation('documentRead', 'Read document', $bizRuleRead);
        $this->auth->createOperation('documentUpdate', 'Edit document', $bizRuleUpdate);
    }

    /**
     * News operations
     */
    protected function _operationsNews()
    {
        $bizRuleRead   = 'return \yii::app()->rbac->bizRuleNewsRead($params);';
        $bizRuleUpdate = 'return \yii::app()->rbac->bizRuleNewsUpdate($params);';

        $this->auth->createOperation('newsCreate', 'Create news');
        $this->auth->createOperation('newsRead', 'Read news', $bizRuleRead);
        $this->auth->createOperation('newsUpdate', 'Edit news', $bizRuleUpdate);
    }

    /**
     * Create first admin user
     */
    public function actionInitAdmin()
    {
        // Define admin params
        $email      = \yii::app()->params['rbac']['admin']['email'];
        $password   = \yii::app()->params['rbac']['admin']['password'];

        // Save admin to DB
        $admin = new \common\models\User();
        $admin->setAttributes(array(
            'firstName' => 'Root',
            'lastName'  => 'Admin',
            'email'     => $email,
            'role'      => User::ROLE_ADMIN,
        ), false);
        $admin->setPassword($password, $password);
        $admin->save();

        // Assign admin role
        $this->auth->assign(User::ROLE_ADMIN, $admin->_id);

        // Display admin params
        if ($admin->hasErrors()) {
            echo "Can't create admin user. Details are below.\n";
            var_dump($admin->getErrors());
        } else {
            echo "Email: $email\n";
            echo "Password: $password\n";
        }

    }

}