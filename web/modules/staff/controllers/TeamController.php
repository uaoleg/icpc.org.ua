<?php

namespace web\modules\staff\controllers;

use \common\components\Rbac;
use \common\models\School;
use \common\models\Team;
use \common\models\User;

class TeamController extends \web\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'manage';

        // Set active main menu item
        $this->setNavActiveItem('main', 'team');
    }

    /**
     * All the rules of access to methods of this controller
     * @return array
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions' => array('manage'),
                'roles' => array(Rbac::OP_TEAM_CREATE, Rbac::OP_TEAM_UPDATE),
            ),
            array(
                'deny',
            )
        );
    }

    /**
     * Manage the team either create or edit it
     */
    public function actionManage()
    {
        // Get user's school
        $school = \yii::app()->user->getInstance()->school;

        // Update team
        if ($this->request->isPostRequest) {

            // Get params
            $teamId         = $this->request->getPost('teamId');
            $teamName       = $this->request->getPost('teamNamePrefix');
            $shortNameUk    = $this->request->getPost('shortNameUk');
            $fullNameEn     = $this->request->getPost('fullNameEn');
            $shortNameEn    = $this->request->getPost('shortNameEn');
            $memberIds      = $this->request->getPost('memberIds');

            // Update school
            $school->scenario = School::SC_ASSIGN_TO_TEAM;
            $school->setAttributes(array(
                'shortNameUk'  => $shortNameUk,
                'fullNameEn'   => $fullNameEn,
                'shortNameEn'  => $shortNameEn
            ), false);
            $school->save();

            // Get team
            if (!empty($teamId)) {
                $team = Team::model()->findByPk(new \MongoId($teamId));
            } else {
                $team = new Team();
            }
           if ($team === null) {
                $this->httpException(404);
           }

            // Update team
            $team->setAttributes(array(
                'name'      => $teamName,
                'coachId'   => \yii::app()->user->id,
                'schoolId'  => $school->_id,
                'memberIds' => $memberIds,
            ), false);
            $team->save();

            // Get errors
            $errors = array_merge($team->getErrors(), $school->getErrors());

            // Render json
            $this->renderJson(array(
                'errors' => (!empty($errors)) ? $errors : false
            ));


        }

        // Display manage page
        else {

            if ($school === null) {

                 $this->render('manageError', array(
                     'error' => \yii::t('app', 'To manage teams, you must specify your school on the {a}profile page{/a}.', array(
                         '{a}'  => '<a href="' . $this->createUrl('/user/me') . '">',
                         '{/a}' => '</a>',
                     )),
                 ));

            } else {

                // Get params
                $teamId = $this->request->getParam('id');

                // Get team
                if (isset($teamId)) {
                    $team = Team::model()->findByPk(new \MongoId($teamId));
                } else {
                    $team = new Team();
                    $team->year = date('Y');
                }

                if (!isset($team)) {
                    $this->httpException(404);
                }

                // Get students from the school
                $allUsers = User::model()->findAllByAttributes(array(
                    'schoolId' => (string)$school->_id,
                    'type'     => User::ROLE_STUDENT
                ));
                $allUsersIds = array();
                foreach ($allUsers as $user) {
                    $allUsersIds[] = (string)$user->_id;
                }

                // Get all team members for this year and from the school
                $usersInTeam = Team::model()->getCollection()->distinct('memberIds', array(
                    'year'     => (int)$team->year,
                    'schoolId' => (string)$school->_id
                ));

                // Get all users from the school and not in the teams
                $usersIds = array_diff($allUsersIds, $usersInTeam);
                $usersMongoIds = array_map(function($id) {
                    return new \MongoId($id);
                }, array_merge($usersIds, $team->memberIds));
                $users = User::model()->findAllByAttributes(array(
                    '_id' => array('$in' => $usersMongoIds)
                ));

                // Render view
                $this->render('manage', array(
                    'school'    => $school,
                    'users'     => $users,
                    'team'      => $team,
                ));

            }
        }
    }

}