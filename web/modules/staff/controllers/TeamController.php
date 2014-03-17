<?php

namespace web\modules\staff\controllers;

use \common\components\Rbac;
use \common\models\School;
use \common\models\Team;
use \common\models\User;

class TeamController extends \web\modules\staff\ext\Controller
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
                'actions' => array('manage', 'schoolComplete'),
                'roles' => array(Rbac::OP_TEAM_CREATE, Rbac::OP_TEAM_UPDATE),
            ),
            array(
                'allow',
                'actions' => array('phaseupdate'),
                'roles' => array(Rbac::OP_TEAM_PHASE_UPDATE),
            ),
            array(
                'allow',
                'actions' => array('leagueUpdate'),
                'roles' => array(Rbac::OP_TEAM_LEAGUE_UPDATE),
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
            $teamName       = $this->request->getPost('name');
            $memberIds      = $this->request->getPost('memberIds');

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

            // Render json
            $this->renderJson(array(
                'errors' => $team->hasErrors() ? $team->getErrors() : false
            ));

        }

        // Display manage page
        else {

            // Get params
            $teamId = $this->request->getParam('id');

            // If school is not complete
            if (empty($school->shortNameUk) || empty($school->fullNameEn) || empty($school->shortNameEn)) {
                \yii::app()->user->setFlash('teamManageId', $teamId);
                $this->redirect($this->createUrl('schoolComplete'));
            }

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
                'type'     => User::ROLE_STUDENT,
            ));
            $allUsersIds = array();
            foreach ($allUsers as $user) {
                $allUsersIds[] = (string)$user->_id;
            }

            // Get all team members for this year and from the school
            $usersInTeam = Team::model()->getCollection()->distinct('memberIds', array(
                'year'     => (int)$team->year,
                'schoolId' => (string)$school->_id,
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

    /**
     * Complete school info before creating a team
     */
    public function actionSchoolComplete()
    {
        $school = \yii::app()->user->getInstance()->school;

        // Update school
        if ($this->request->isPostRequest) {

            // Get params
            $shortNameUk    = $this->request->getPost('shortNameUk');
            $fullNameEn     = $this->request->getPost('fullNameEn');
            $shortNameEn    = $this->request->getPost('shortNameEn');

            // Update school
            $school->scenario = School::SC_ASSIGN_TO_TEAM;
            $school->setAttributes(array(
                'shortNameUk'  => $shortNameUk,
                'fullNameEn'   => $fullNameEn,
                'shortNameEn'  => $shortNameEn,
            ), false);
            $school->save();

            // Define redirect URL
            if (!$school->hasErrors()) {
                $teamId = \yii::app()->user->getFlash('teamManageId');
                $urlParams = array();
                if (!empty($teamId)) {
                    $urlParams['id'] = $teamId;
                }
                $url = $this->createUrl('manage', $urlParams);
            } else {
                $url = '';
            }

            // Render json
            $this->renderJson(array(
                'errors'    => $school->hasErrors() ? $school->getErrors() : false,
                'url'       => $url,
            ));
        }

        // Show complete page
        else {
            if ($school === null) {
                $this->render('manageError', array(
                    'error' => \yii::t('app', 'To manage teams, you must specify your school on the {a}profile page{/a}.', array(
                            '{a}'  => '<a href="' . $this->createUrl('/user/me') . '">',
                            '{/a}' => '</a>',
                        )),
                ));
            } else {
                $this->render('schoolComplete', array(
                    'school' => $school,
                ));
            }
        }


    }

    /**
     * Update team phase
     */
    public function actionPhaseUpdate()
    {
        // Get params
        $id     = $this->request->getParam('id');
        $phase  = $this->request->getParam('phase');

        // Get team
        $team = Team::model()->findByPk(new \MongoId($id));

        // Update phase
        $team->scenario = Team::SC_PHASE_UPDATE;
        $team->phase = (int)$phase;
        if ($team->validate(array('phase'))) {
            $team->save(false);
        }
    }

    /**
     * Update team league
     */
    public function actionLeagueUpdate()
    {
        // Get params
        $teamId = $this->request->getParam('team');
        $league = $this->request->getParam('league');

        // Update team
        $team = Team::model()->findByPk(new \MongoId($teamId));
        $team->league = $league;
        $team->save();

        // Redirect to team page
        $this->redirect($this->createAbsoluteUrl('/team/view', array('id' => $teamId)));
    }

}