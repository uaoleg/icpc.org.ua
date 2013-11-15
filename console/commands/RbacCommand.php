<?php

use \common\components\Rbac,
    \common\ext\MongoDb\Auth,
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
         * Delete all auth items
         */
        Auth\Item::model()->deleteAll();
        $this->auth->init();

        /**
         * Create operations
         */
        $this->_operationsDocument();
        $this->_operationsNews();
        $this->_operationsTeam();

        /**
         * Guest role
         */
        $this->_createRole(User::ROLE_GUEST, array(
            Rbac::OP_DOCUMENT_READ,
            Rbac::OP_NEWS_READ,
            Rbac::OP_TEAM_READ,
        ));

        /**
         * User role
         */
        $this->_createRole(User::ROLE_USER, array(
            User::ROLE_GUEST,
        ));

        /**
         * Student role
         */
        $this->_createRole(User::ROLE_STUDENT, array(
            User::ROLE_USER,
        ));

        /**
         * Coach role
         */
        $this->_createRole(User::ROLE_COACH, array(
            User::ROLE_USER,
            Rbac::OP_TEAM_CREATE,
            Rbac::OP_TEAM_UPDATE,
        ));

        /**
         * Coordinator of State role
         */
        $this->_createRole(User::ROLE_COORDINATOR_STATE, array(
            User::ROLE_USER,
            Rbac::OP_DOCUMENT_CREATE,
            Rbac::OP_DOCUMENT_UPDATE,
            Rbac::OP_DOCUMENT_DELETE,
            Rbac::OP_NEWS_CREATE,
            Rbac::OP_NEWS_UPDATE,
        ));

        /**
         * Coordinator of Region role
         */
        $this->_createRole(User::ROLE_COORDINATOR_REGION, array(
            User::ROLE_COORDINATOR_STATE,
        ));

        /**
         * Coordinator of Ukraine role
         */
        $this->_createRole(User::ROLE_COORDINATOR_UKRAINE, array(
            User::ROLE_COORDINATOR_REGION,
        ));

        /**
         * Admin role
         */
        $this->_createRole(User::ROLE_ADMIN, array(
            User::ROLE_COORDINATOR_UKRAINE,
        ));

        echo "RBAC inited succesfully.";
    }

    protected function _createRole($roleName, array $children)
    {
        $role = $this->auth->createRole($roleName);
        foreach ($children as $child) {
            if (!$role->hasChild($child)) {
                $role->addChild($child);
            }
        }
    }

    /**
     * Assign the list of given operation to the given role
     *
     * @param \CAuthItem $authItem
     * @param array $operationList
     */
    protected function _assignOperations(\CAuthItem $authItem, array $operationList)
    {
        foreach ($operationList as $operation) {
            if (!$authItem->hasChild($operation)) {
                $authItem->addChild($operation);
            }
        }
    }

    /**
     * Document operations
     */
    protected function _operationsDocument()
    {
        $this->auth->createOperation(Rbac::OP_DOCUMENT_CREATE, 'Create document');
        $this->auth->createOperation(Rbac::OP_DOCUMENT_READ, 'Read document');
        $this->auth->createOperation(Rbac::OP_DOCUMENT_UPDATE, 'Edit document');
        $this->auth->createOperation(Rbac::OP_DOCUMENT_DELETE, 'Delete document');
    }

    /**
     * News operations
     */
    protected function _operationsNews()
    {
        $bizRuleRead   = 'return \yii::app()->rbac->bizRuleNewsRead($params);';
        $bizRuleUpdate = 'return \yii::app()->rbac->bizRuleNewsUpdate($params);';

        $this->auth->createOperation(Rbac::OP_NEWS_CREATE, 'Create news');
        $this->auth->createOperation(Rbac::OP_NEWS_READ, 'Read news', $bizRuleRead);
        $this->auth->createOperation(Rbac::OP_NEWS_UPDATE, 'Edit news', $bizRuleUpdate);
    }

    /**
     * Team operations
     */
    protected function _operationsTeam()
    {
        $bizRuleUpdate = 'return \yii::app()->rbac->bizRuleTeamUpdate($params);';

        $this->auth->createOperation(Rbac::OP_TEAM_CREATE, 'Create team');
        $this->auth->createOperation(Rbac::OP_TEAM_READ, 'Read team');
        $this->auth->createOperation(Rbac::OP_TEAM_UPDATE, 'Edit team', $bizRuleUpdate);
    }

    /**
     * Create first admin user
     */
    public function actionInitAdmin()
    {
        // Define admin params
        $email      = \yii::app()->params['rbac']['admin']['email'];
        $password   = \yii::app()->params['rbac']['admin']['password'];
        $schoolId   = \yii::app()->params['rbac']['admin']['schoolId'];

        // Save admin to DB
        $admin = new \common\models\User();
        $admin->setAttributes(array(
            'firstName'     => 'Root',
            'middleName'    => 'System',
            'lastName'      => 'Admin',
            'email'         => $email,
            'type'          => User::ROLE_ADMIN,
            'schoolId'      => $schoolId
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