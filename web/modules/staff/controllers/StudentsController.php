<?php
namespace web\modules\staff\controllers;

use \common\models\ViewTable\Student as ViewStudent;
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
        $this->_rebuildStudentsCollection();

        // Render view
        $this->render('index', array(
            'lang'  => \yii::app()->languageCore,
        ));
    }

    /**
     * Prepare user profile for export or show
     */
    protected function _prepareUser(ViewStudent $user)
    {
        $lang = \yii::app()->languageCore;
        $school = (isset($user->{'schoolFullName' . ucfirst($lang)}))
            ? $user->{'schoolFullName' . ucfirst($lang)}
            : $user->schoolFullNameUk;
        $nameKey = 'name' . ucfirst($lang);
        $schoolFullNameKey = 'schoolFullName' . ucfirst($lang);

        return array(
            'id'                => (string)$user->_id,
            $nameKey            => \web\widgets\user\Name::create(array('user' => $user, 'lang' => \yii::app()->language), true),
            'speciality'        => (string)$user->speciality,
            'group'             => (string)$user->group,
            'email'             => $user->email,
            'phone'             => $user->phone,
            'course'            => $user->course,
            'dateBirthday'      => date('Y-m-d', $user->dateOfBirth),
            'dateCreated'       => date('Y-m-d H:i:s', $user->dateCreated),
            'isApprovedStudent' => $this->renderPartial('index/action', array( 'user' => $user ), true),
            $schoolFullNameKey  => $school,
        );
    }

    /**
     * Rebuild view table collection of students
     */
    protected function _rebuildStudentsCollection()
    {
        if (ViewStudent::model()->cache->get('collectionIsUpToDate')) {
            return;
        }

        ViewStudent::model()->getCollection()->remove();

        $criteria = new \EMongoCriteria();
        $criteria->addCond('type', '==', User::ROLE_STUDENT);
        $list = User::model()->findAll($criteria);

        foreach ($list as $user) {
            $student = new ViewStudent();
            $student->setIsNewRecord(true);
            $student->_id = $user->_id;

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

            // Save student
            $student->setAttributes(array(
                '_id'          => $user->_id,
                'firstNameUk'  => $user->firstNameUk,
                'middleNameUk' => $user->middleNameUk,
                'lastNameUk'   => $user->lastNameUk,
                'firstNameEn'  => $user->firstNameEn,
                'middleNameEn' => $user->middleNameEn,
                'lastNameEn'   => $user->lastNameEn,
                'email'        => $user->email,
                'speciality'   => (string) $user->info->speciality,
                'group'        => (string) $user->info->group,
                'course'       => $user->info->course,
                'dateCreated'  => $user->dateCreated,
                'dateOfBirth'  => $user->info->dateOfBirth,
                'phone'        => implode(', ', $phone),
                'isApprovedStudent'=> $user->isApprovedStudent,
                'schoolFullNameUk' => $user->school->fullNameUk,
                'schoolFullNameEn' => $user->school->fullNameEn,
            ), false);
            $student->save();
        }

        ViewStudent::model()->cache->set('collectionIsUpToDate', true, SECONDS_IN_HOUR);
    }

    /**
     * Method for jqGrid which returns all the students
     */
    public function actionGetListJson()
    {
        // Get jqGrid params
        $criteria = new \EMongoCriteria();
        if (!\yii::app()->user->checkAccess(User::ROLE_ADMIN)) {
            $criteria->addCond('isApprovedStudent', '==', true); // Only admin can see deleted students
        }
        $jqgrid = $this->_getJqgridParams(ViewStudent::model(), $criteria);

        // Get rows
        $rows = array();
        foreach ($jqgrid['itemList'] as $user) {
            $rows[] =  $this->_prepareUser($user);
            \yii::app()->user->setState('userCriteriaForExport', $jqgrid['criteria']);
        }

        // Render json
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
        $lang = \yii::app()->languageCore;

        // List of table columns
        $list = array(array(
            'name'         => \yii::t('app', 'Name'),
            'school'       => \yii::t('app', 'School'),
            'speciality'   => \yii::t('app', 'Speciality'),
            'group'        => \yii::t('app', 'Group'),
            'email'        => \yii::t('app', 'Email'),
            'phone'        => \yii::t('app', 'Phone'),
            'course'       => \yii::t('app', 'Course'),
            'dateBirthday' => \yii::t('app', 'Date of birth'),
        ));

        // Find all students
        $criteria = \yii::app()->user->getState('userCriteriaForExport');
        $criteria->limit(0);
        $criteria->offset(0);
        $students = ViewStudent::model()->findAll($criteria);
        foreach ($students as $student) {
            $item =  $this->_prepareUser($student);
            $item['name'] = $item['name' . ucfirst($lang)];
            $item['school'] = $item['schoolFullName' . ucfirst($lang)];
            $list[] = $item;
        }

        // Render CSV
        $this->renderCsv($list, "icpc_users_cs_{$this->getYear()}.csv", function($user) {
            return array(
                $user['name'], $user['school'], $user['speciality'], $user['group'], $user['email'], $user['phone'], $user['course'], $user['dateBirthday']
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