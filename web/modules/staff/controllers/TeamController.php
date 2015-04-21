<?php

namespace web\modules\staff\controllers;

use \common\components\Rbac;
use \common\models\School;
use \common\models\Team;
use \common\models\User;
use EMongoCriteria;

class TeamController extends \web\modules\staff\ext\Controller
{

    const BAYLOR_STATUS_ACCEPTED = '(accepted)';

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
        // Get params
        $teamId = $this->request->getParam('teamId');

        // Get team
        if (!empty($teamId)) {
            $team = Team::model()->findByPk(new \MongoId($teamId));
        } else {
            $team = new Team();
        }

        // Return list of rules
        return array(
            array(
                'allow',
                'actions' => array('manage', 'import', 'postImport', 'postTeams','schoolComplete'),
                'roles' => array(Rbac::OP_TEAM_CREATE, Rbac::OP_TEAM_UPDATE => array('team' => $team)),
            ),
            array(
                'allow',
                'actions' => array('exportOne'),
                'roles' => array(Rbac::OP_TEAM_CREATE, Rbac::OP_TEAM_EXPORT_ONE => array('team' => $team)),
            ),
            array(
                'allow',
                'actions' => array('delete'),
                'roles' => array(Rbac::OP_TEAM_DELETE => array('team' => $team)),
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
     * Get teams from baylor
     */
    public function actionPostTeams()
    {
        // Get params
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');

        $response = \yii::app()->baylor->getTeamList($email, $password);

        $imported = array();
        $teams = array();

        $errors = array();

        if (!empty($response) && empty($response['error']) && !empty($response['data'])) {
            $criteria = new EMongoCriteria();
            $criteria->addCond('baylorId', '!=', null);
            $importedList = Team::model()->findAll($criteria);
            foreach ($importedList as $item) {
                $imported[] = (string)$item->baylorId;
            }

            foreach ( $response['data'] as $team ) {
                if (!in_array($team['id'], $imported)) {
                    $teams[] = $team;
                }
            }
        }

        if (empty($teams)) {
            $errors[] = \yii::t('app', 'You have no teams to import.');
        }

        // Render json
        $this->renderJson(array(
            'errors'   => !empty($errors) ? $errors : false,
            'teams'    => $teams,
        ));
    }

    /**
     * Import team from baylor
     */
    public function actionPostImport()
    {
        // Get params
        $teamId     = $this->request->getPost('team');
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');

        // Get team
        $criteria = new EMongoCriteria();
        $criteria->addCond('baylorId', '==', $teamId);
        $team = Team::model()->findFirst($criteria);

        $errors = false;

        if (empty($team)) {
            $response = \yii::app()->baylor->importTeam($email, $password, $teamId);

            if (!empty($response) && empty($response['error']) && !empty($response['data']['team'])) {
                $team = new Team();

                if (empty($response['data']['team']['status']) || strtolower($response['data']['team']['status']) != self::BAYLOR_STATUS_ACCEPTED) {
                    $errors[] = \yii::t('app', 'Team should be accepted.');
                }

                $memberIds = array();
                if (empty($errors) && !empty($response['data']['team']['members'])) {
                    foreach ($response['data']['team']['members'] as $member) {
                        $user = User::model()->findByAttributes([
                            'email' => mb_strtolower($member['email']),
                        ]);
                        if (!empty($user)) {
                            $memberIds[] = (string)$user->_id;
                        } else {
                            $errors[] = \yii::t('app', 'User {name} with email {email} was not found.', [
                                '{email}'   => $member['email'],
                                '{name}'    => $member['name'],
                            ]);
                        }
                    }
                }

                if (empty($errors)) {
                    $team->setAttributes(array(
                        'name'               => $response['data']['team']['title'],
                        'coachId'            => \yii::app()->user->id,
                        'schoolId'           => \yii::app()->user->getInstance()->school->_id,
                        'memberIds'          => $memberIds,
                        'baylorId'           => $response['data']['team']['id'],
                        'isOutOfCompetition' => false
                    ), false);

                    $team->save();
                    $errors = $team->hasErrors() ? $team->getErrors() : false;
                }
            }
        } else {
            $errors[] = \yii::t('app', 'This team has been imported before.');
        }

        // Render json
        $this->renderJson(array(
            'errors' => $errors,
            'teamId' => !empty($team->_id) ? (string)$team->_id : false,
        ));
    }

    /**
     * Render import page
     */
    public function actionImport()
    {
        $this->render('import', array(
        ));
    }

    /**
     * Generate team's registration form
     */
    public function actionExportOne()
    {
        // Get params
        $teamId = $this->request->getParam('id' , null);
        if (empty($teamId)){
            $this->httpException(404);
        }

        // Get team
        $team = Team::model()->findByPk(new \MongoId($teamId));
        if (empty($team)){
            $this->httpException(404);
        }

        // Render view
        $this->layout = false;
        $this->render('exportOne', array(
            'team' => $team,
        ));
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
            $teamId             = $this->request->getPost('teamId');
            $teamName           = $this->request->getPost('name');
            $memberIds          = $this->request->getPost('memberIds');
            $isOutOfCompetition = true;

            // Get team
            if (!empty($teamId)) {
                $team = Team::model()->findByPk(new \MongoId($teamId));
            } else {
                $team = new Team();
            }

            if ($team === null) {
                $this->httpException(404);
            }

            //You can't manage team that ws imported from bailor
            if (!empty($team->baylorId)) {
                $this->httpException(404);
            }

            // Update team
            $team->setAttributes(array(
                'name'               => $teamName,
                'coachId'            => \yii::app()->user->id,
                'schoolId'           => $school->_id,
                'memberIds'          => $memberIds,
                'isOutOfCompetition' => $isOutOfCompetition
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
                'year'      => (int)$team->year,
                'schoolId'  => (string)$school->_id,
                'isDeleted' => false,
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

    /**
     * Delete team action
     */
    public function actionDelete()
    {
        // Get params
        $teamId = $this->request->getParam('teamId');

        // Get team
        $team = Team::model()->findByPk(new \MongoId($teamId));

        // Mark as deleted
        if (!isset($team)) {
            $this->httpException(404);
        } else {
            $team->isDeleted = true;
            $team->save();
        }
    }

}