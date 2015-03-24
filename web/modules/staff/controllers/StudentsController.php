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
        // Render view
        $this->render('index');
    }

    /**
     * Prepare user profile for export or show
     */
    protected function _prepareUser($user)
    {
        $school = (isset($user->school->{'fullName' . ucfirst(\yii::app()->language)}))
            ? $user->school->{'fullName' . ucfirst(\yii::app()->language)}
            : $user->school->fullNameUk;

        $phone = array();

        if (!empty($user->info->phoneHome)) {
            $phone['phoneHome'] = $user->info->phoneHome;
        }
        if (!empty($user->info->phoneMobile)) {
            $phone['phoneMobile'] = $user->info->phoneMobile;
        }
        if (!empty($user->info->phoneWork)) {
            $phone['phoneWork'] = $user->info->phoneWork;
        }
        return array(
            'id'                => (string) $user->_id,
            'name'              => \web\widgets\user\Name::create( array(
                'user' => $user,
                'lang' => \yii::app()->language
            ), true ),
            'school'            => $school,
            'speciality'        => (string) $user->info->speciality,
            'group'             => (string) $user->info->group,
            'email'             => $user->email,
            'phone'             => implode(', ',$phone),
            'course'            => $user->info->course,
            'dateBirthday'      => date( 'Y-m-d H:i:s', $user->info->dateOfBirth ),
            'dateCreated'       => date( 'Y-m-d H:i:s', $user->dateCreated ),
            'isApprovedStudent' => $this->renderPartial( 'index/action', array( 'user' => $user ), true )
        );
    }

    /**
     * Method for jqGrid which returns all the students
     */
    public function actionGetListJson()
    {
        // Get jqGrid params
        $criteria = new \EMongoCriteria();
        $criteria->addCond('type', '==', User::ROLE_STUDENT);
        $jqgrid = $this->_getJqgridParams(User::model(), $criteria);

        $rows = array();
        foreach ($jqgrid['itemList'] as $user) {
            $idsToRemember[] = (string)$user->_id;
            $rows[] = $this->_prepareUser($user);

            \yii::app()->user->setState('userIdsForExport', $idsToRemember);
        }

        $this->renderJson(array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
        ));
    }

    /**
     * Method for export list of student
     */
    public function actionExport()
    {
        // Get params
        $userIds = \yii::app()->user->getState('userIdsForExport');
        $userIds = array_map(function($id) {
            return new \MongoId($id);
        }, $userIds);

        // Get list of teams
        $criteria = new \EMongoCriteria();
        $criteria->addCond('_id', 'in', $userIds);
        $users = User::model()->findAll($criteria);

        $list = array();
        foreach ($users as $user)
        {
            $list[] = $this->_prepareUser($user);
        }

        // Render CSV
        $this->renderCsv($list, "icpc_users_cs_{$this->getYear()}.csv", function($user) {
            return array(
                $user['name'], $user['school'],  $user['speciality'], $user['group'], $user['email'], $user['phone'], $user['course'], $user['dateBirthday']
            );
        });
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

        // Assign student role to the user
        if ($state) {
            $user->isApprovedStudent = true;
        }

        // Revoke coordination roles
        else {
            $user->isApprovedStudent = false;
        }

        $user->save();
    }

}