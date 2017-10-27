<?php
namespace frontend\modules\staff\controllers;

use \common\models\User;
use \common\components\Rbac;
use \frontend\modules\staff\search\StudentSearch;

class StudentsController extends \frontend\modules\staff\ext\Controller
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
        // Get list of students
        $search = new StudentSearch;
        $provider = $search->search(\yii::$app->request->queryParams);

        // Render view
        return $this->render('index', array(
            'provider'  => $provider,
            'search'    => $search,
        ));
    }

    /**
     * Prepare user profile for export or show
     */
    protected function _prepareUser(ViewStudent $user)
    {
        $lang = \yii::$app->user->languageCore;
        $school = (isset($user->{'schoolFullName' . ucfirst($lang)}))
            ? $user->{'schoolFullName' . ucfirst($lang)}
            : $user->schoolFullNameUk;
        $nameKey = 'name' . ucfirst($lang);
        $schoolFullNameKey = 'schoolFullName' . ucfirst($lang);

        return array(
            'id'                => $user->id,
            $nameKey            => \frontend\widgets\user\Name::widget(['user' => $user, 'lang' => \yii::$app->language]),
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
     * Method for export list of student
     */
    public function actionExport()
    {
        // Get params
        $lang = \yii::$app->user->languageCore;

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
        $studentsQuery = \yii::$app->user->getState('userCriteriaForExport');
        $studentsQuery->limit(0);
        $studentsQuery->offset(0);
        $students = $studentsQuery->all();
        foreach ($students as $student) {
            $item = $this->_prepareUser($student);
            $item['name'] = $item['name' . ucfirst($lang)];
            $item['school'] = $item['schoolFullName' . ucfirst($lang)];
            $list[] = $item;
        }

        // Render CSV
        return $this->renderCsv($list, "icpc_users_cs_{$this->getYear()}.csv", function($user) {
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
        $userId = \yii::$app->request->post('userId');
        $state  = (bool)\yii::$app->request->post('state', 0);

        // Get user
        $user = User::findOne($userId);
        if ($user === null) {
            return $this->httpException(404);
        }

        // Check access
        if (!\yii::$app->user->can(Rbac::OP_STUDENT_SET_STATUS)) {
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