<?php

namespace frontend\modules\staff\controllers;

use \common\components\Rbac;
use \common\models\School;
use \common\models\Team;
use \common\models\User;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Url;

class TeamController extends \frontend\modules\staff\ext\Controller
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
        // Get params
        $teamId = \yii::$app->request->get('teamId');

        // Get team
        if (!empty($teamId)) {
            $team = Team::findOne($teamId);
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
                'actions' => array('baylorSync'),
                'roles' => array(Rbac::OP_TEAM_SYNC => array('team' => $team)),
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
     * Get teams from Baylor
     */
    public function actionPostTeams()
    {
        // Get params
        $email      = \yii::$app->request->post('email');
        $password   = \yii::$app->request->post('password');

        $response = \yii::$app->baylor->getTeamList($email, $password);

        $imported = array();
        $teams = array();

        $errors = array();

        if (!empty($response) && empty($response['error']) && !empty($response['data'])) {
            $importedList = Team::findAll(['!=', 'baylorId', null]);
            foreach ($importedList as $item) {
                $imported[] = (string)$item->baylorId;
            }

            foreach ( $response['data'] as $team ) {
                if (!in_array($team['id'], $imported)) {
                    $teams[] = $team;
                }
            }
        }

        // Display error
        if (!\yii::$app->baylor->loginSuccess) {
            $errors[] = \yii::t('app', 'Wrong username or password.');
        } elseif (empty($teams)) {
            $errors[] = \yii::t('app', 'You have no teams to import.');
        }

        // Render json
        return $this->renderJson(array(
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
        $teamId     = \yii::$app->request->post('team');
        $email      = \yii::$app->request->post('email');
        $password   = \yii::$app->request->post('password');

        // Get team
        $team = Team::findOne(['baylorId' => $teamId]);

        $errors = false;

        if (empty($team)) {
            $response = \yii::$app->baylor->importTeam($email, $password, $teamId);

            if (!empty($response) && empty($response['error']) && !empty($response['data']['team'])) {
                $team = new Team();

                if (false
                        || empty($response['data']['team']['status'])
                        || strtolower($response['data']['team']['status']) != \common\components\Baylor::STATUS_ACCEPTED
                    ) {
/** @todo Enable this check */
//                    $errors[] = \yii::t('app', 'Team should be accepted.');
                }

                $memberIds = array();
                if (empty($errors) && !empty($response['data']['team']['members'])) {
                    foreach ($response['data']['team']['members'] as $member) {
                        $user = User::findOne(['email' => mb_strtolower($member['email'])]);
                        if ($user !== null) {
                            $memberIds[] = $user->id;
                        } else {
                            $errors[] = \yii::t('app', 'User {name} with email {email} was not found.', [
                                'email' => $member['email'],
                                'name'  => $member['name'],
                            ]);
                        }
                    }
                }

                if (empty($errors)) {
                    $team->setAttributes(array(
                        'name'               => $response['data']['team']['title'],
                        'coachId'            => \yii::$app->user->id,
                        'schoolId'           => \yii::$app->user->identity->school->id,
                        'baylorId'           => $response['data']['team']['id'],
                        'isOutOfCompetition' => false
                    ), false);

                    $team->save();
                    Team\Member::updateTeamMembers($team, $memberIds);

                    $errors = $team->hasErrors() ? $team->getErrors() : false;
                }
            }
        } else {
            $errors[] = \yii::t('app', 'This team has been imported before.');
        }

        // Render json
        return $this->renderJson(array(
            'errors' => $errors,
            'teamId' => !empty($team->id) ? $team->id : false,
        ));
    }

    /**
     * Render import page
     */
    public function actionImport()
    {
        return $this->render('import', array(
        ));
    }

    /**
     * Generate team's registration form
     */
    public function actionExportOne()
    {
        // Get params
        $teamId = \yii::$app->request->get('id' , null);
        if (empty($teamId)){
            $this->httpException(404);
        }

        // Get team
        $team = Team::findOne($teamId);
        if (empty($team)){
            $this->httpException(404);
        }

        // Render view
        $this->layout = false;
        return $this->render('exportOne', array(
            'team' => $team,
        ));
    }

    /**
     * Manage the team either create or edit it
     */
    public function actionManage()
    {
        // Get user's school
        $school = \yii::$app->user->identity->school;

        // Update team
        if (\yii::$app->request->isPost) {

            // Get params
            $teamId             = \yii::$app->request->post('teamId');
            $teamName           = \yii::$app->request->post('name');
            $memberIds          = \yii::$app->request->post('memberIds');
            $isOutOfCompetition = true;

            // Get team
            if (!empty($teamId)) {
                $team = Team::findOne($teamId);
                if ($team === null) {
                    $this->httpException(404);
                }
            } else {
                $team = new Team();
            }

            // You can't manage team that was imported from Bailor
            if (!empty($team->baylorId)) {
                $this->httpException(403);
            }

            // Update team and list of members
            $team->setAttributes([
                'name'               => $teamName,
                'coachId'            => \yii::$app->user->id,
                'schoolId'           => $school->id,
                'isOutOfCompetition' => $isOutOfCompetition
            ]);
            if ($team->save() && is_array($memberIds)) {
                Team\Member::deleteAll(['teamId' => $team->id]);
                foreach ($memberIds as $memberId) {
                    $member = new Team\Member([
                        'teamId' => $team->id,
                        'userId' => $memberId,
                    ]);
                    $member->save();
                }
            }

            // Render json
            return $this->renderJson(array(
                'errors' => $team->hasErrors() ? $team->getErrors() : false
            ));

        }

        // Display manage page
        else {

            // Get params
            $teamId = \yii::$app->request->get('id');

            // If school is not complete
            if (empty($school->shortNameUk) || empty($school->fullNameEn) || empty($school->shortNameEn)) {
                \yii::$app->user->setState('teamManageId', $teamId);
                $this->redirect(['school-complete']);
            }

            // Get team
            if (isset($teamId)) {
                $team = Team::findOne($teamId);
            } else {
                $team = new Team();
                $team->year = date('Y');
            }

            if (!isset($team)) {
                $this->httpException(404);
            }

            // Get teams for this year and from the school
            $teams = Team::find()
                ->select('id')
                ->andWhere([
                    'year'      => (int)$team->year,
                    'schoolId'  => $school->id,
                    'isDeleted' => false,
                ])
                ->asArray()
                ->all()
            ;
            $teamsIds = ArrayHelper::getColumn($teams, 'id');

            // Get all users from the school and not in the teams
            $users = User::find()
                ->alias('user')
                ->leftJoin(
                    ['member' => Team\Member::tableName()],
                    [
                        'AND',
                        'member.userId = user.id',
                        ['IN', 'member.teamId', $teamsIds],
                    ]
                )
                ->andWhere([
                    'user.schoolId' => $school->id,
                    'user.type'     => User::ROLE_STUDENT,
                ])
                ->andWhere('member.teamId IS NULL OR member.teamId = :teamId', [
                    ':teamId' => $team->id,
                ])
                ->all()
            ;

            // Render view
            return $this->render('manage', array(
                'team'      => $team,
                'users'     => $users,
                'school'    => $school,
            ));

        }
    }

    /**
     * Sync team that already exissts
     */
    public function actionBaylorSync()
    {
        if (\yii::$app->request->isPost && \yii::$app->request->isAjax) {
            $email    = \yii::$app->request->get('email');
            $password = \yii::$app->request->get('password');
            $teamId   = \yii::$app->request->get('teamId');
            $errors   = array();

            \yii::$app->user->setState('baylor_email', $email);

            $team = Team::findOne($teamId);

            $result = \yii::$app->baylor->importTeam($email, $password, $team->baylorId);

            if(empty($result['errors'])) {

                // Save the team info
                $teamInfo = $result['data']['team'];

                $memberIds = array();
                foreach ($teamInfo['members'] as $member) {

                    // Get user
                    $user = User::findOne(['email' => mb_strtolower($member['email'])]);

                    // Push to the list of members
                    if ($user !== null) {
                        $memberIds[] = (string)$user->id;
                    } else {
                        $errors[] = \yii::t('app', 'User {name} with email {email} was not found.', [
                            'email' => $member['email'],
                            'name'  => $member['name'],
                        ]);
                    }
                }

                if (empty($errors)) {

                    // Update name
                    $team->name = $teamInfo['title'];
                    if (!$team->save(true, ['name'])) {
                        $errors += $team->getErrors('name');
                    }

                    // Update members
                    if (!Team\Member::updateTeamMembers($team, $memberIds)) {
                        $errors += $team->getErrors('members');
                    }
                }

            } else {
                return $this->renderJson(array(
                    'errors' => true
                ));
            }

            return $this->renderJson(array(
                'errors' => (empty($errors)) ? false : $errors
            ));
        }
    }

    /**
     * Complete school info before creating a team
     */
    public function actionSchoolComplete()
    {
        $school = \yii::$app->user->identity->school;

        // Update school
        if (\yii::$app->request->isPost) {

            // Get params
            $shortNameUk    = \yii::$app->request->post('shortNameUk');
            $fullNameEn     = \yii::$app->request->post('fullNameEn');
            $shortNameEn    = \yii::$app->request->post('shortNameEn');

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
                $teamId = \yii::$app->user->getState('teamManageId', null, true);
                $urlParams = ['manage'];
                if (!empty($teamId)) {
                    $urlParams['id'] = $teamId;
                }
                $url = Url::toRoute($urlParams);
            } else {
                $url = '';
            }

            // Render json
            return $this->renderJson(array(
                'errors'    => $school->hasErrors() ? $school->getErrors() : false,
                'url'       => $url,
            ));
        }

        // Show complete page
        else {
            if ($school === null) {
                return $this->render('manageError', array(
                    'error' => \yii::t('app', 'To manage teams, you must specify your school on the {a_}profile page{_a}.', [
                            'a_' => '<a href="' . Url::toRoute(['/user/me']) . '">',
                            '_a' => '</a>',
                        ]),
                ));
            } else {
                return $this->render('schoolComplete', array(
                    'school' => $school,
                ));
            }
        }


    }

    /**
     * Update team phase
     */
    public function actionPhaseUpdate($id)
    {
        // Get params
        $phase = (int)\yii::$app->request->post('phase');

        // Get team
        $team = Team::findOne($id);

        // Update phase
        $team->scenario = Team::SC_PHASE_UPDATE;
        $team->phase = $phase;
        $team->save(true, ['phase', 'timeUpdated']);
    }

    /**
     * Update team league
     */
    public function actionLeagueUpdate()
    {
        // Get params
        $teamId = \yii::$app->request->get('team');
        $league = \yii::$app->request->get('league');

        // Update team
        $team = Team::findOne($teamId);
        $team->league = $league;
        $team->save();

        // Redirect to team page
        $this->redirect(['/team/view', 'id' => $teamId]);
    }

    /**
     * Delete team action
     */
    public function actionDelete($id)
    {
        // Get team
        $team = Team::findOne($id);

        // Mark as deleted
        if (!isset($team)) {
            $this->httpException(404);
        } else {
            $team->isDeleted = true;
            $team->save();
        }
    }

}