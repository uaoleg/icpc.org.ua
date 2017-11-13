<?php

namespace frontend\controllers;

use \common\models\Result;
use \common\models\Team;
use \frontend\search\TeamSearch;

class TeamController extends BaseController
{
    /**
     * Returns the access rules for this controller
     * @return array
     */
    public function accessRules()
    {
        // Return rules
        return array(
            array(
                'allow',
                'actions'   => array('exportCheckingSystem', 'exportRegistration'),
                'roles'     => array(\common\components\Rbac::OP_TEAM_EXPORT_ALL),
            ),
            array(
                'deny',
                'actions'   => array('exportCheckingSystem', 'exportRegistration'),
            ),
            array(
                'allow',
            ),
        );
    }

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'list';

        // Set active main menu item
        $this->setNavActiveItem('main', 'team');
    }

    /**
     * List all the teams
     */
    public function actionList()
    {
        // Get params
        $year = $this->getYear();

        // Get list of teams
        $teamsCount = Team::findAll(['year' => $year]);

        // Get list of teams
        $teamsSearch = new TeamSearch([
            'year'  => $this->getYear(),
        ]);
        $teamsProvider = $teamsSearch->search(\yii::$app->request->queryParams);
        \yii::$app->user->setState('teamExportQuery', $teamsProvider->query);

        // Render view
        return $this->render('list', array(
            'teamsProvider' => $teamsProvider,
            'teamsSearch'   => $teamsSearch,
            'year'          => $year,
            'teamsCount'    => $teamsCount,
        ));
    }

    /**
     * Method which shows the information about team
     */
    public function actionView()
    {
        // Get params
        $teamId = \yii::$app->request->get('id');

        // Get team
        $team = Team::findOne($teamId);
        if (($team === null) || $team->isDeleted) {
            $this->httpException(404);
        }

        // Get results
        $results = Result::find()
            ->andWhere([
                'teamId'    => $teamId,
                'year'      => $team->year,
            ])
            ->orderBy('phase')
            ->all()
        ;

        // Render view
        return $this->render('view', array(
            'team'       => $team,
            'coach'      => $team->coach,
            'results'    => $results,
        ));
    }

    /**
     * Action to export teams list in CSV for checking system
     */
    public function actionExportCheckingSystem()
    {
        // Get list of teams
        $query = \yii::$app->user->getState('teamExportQuery');
        if (!$query) {
            return $this->redirect(['list']);
        }
        $query->limit(null);
        $teams = $query->all();

        // Render CSV
        return $this->renderCsv($teams, "icpc_teams_cs_{$this->getYear()}.csv", function($team) {
            return [
                $team->name, $team->school->fullNameUk, $team->school->shortNameUk,
                \frontend\widgets\user\Name::widget(['user' => $team->coach, 'lang' => 'uk']),
            ];
        });
    }

    /**
     * Action to export teams list in CSV for registration
     */
    public function actionExportRegistration()
    {
        // Get list of teams
        $query = \yii::$app->user->getState('teamExportQuery');
        if (!$query) {
            return $this->redirect(['list']);
        }
        $query->limit(null);
        $teams = $query->all();

        // Render CSV
        return $this->renderCsv($teams, "icpc_teams_r_{$this->getYear()}.csv", function($team) {
            $arrayToPut = array(
                $team->name, $team->school->fullNameUk, $team->school->shortNameUk,
                \frontend\widgets\user\Name::widget(['user' => $team->coach, 'lang' => 'uk']),
                \frontend\widgets\user\Name::widget(['user' => $team->coach, 'lang' => 'en']),
                $team->coach->email,
            );
            foreach ($team->members as $member) {
                $arrayToPut[] = \frontend\widgets\user\Name::widget(array('user' => $member->user, 'lang' => 'uk'));
                $arrayToPut[] = \frontend\widgets\user\Name::widget(array('user' => $member->user, 'lang' => 'en'));
                $arrayToPut[] = $member->user->email;
            }
            return $arrayToPut;
        });
    }

}