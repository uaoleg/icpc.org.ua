<?php

namespace web\controllers;

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
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('year', '==', $year)
            ->sort('name', \EMongoCriteria::SORT_ASC);
        $teams = Team::model()->findAll($criteria);

        // Render view
        $this->render('list', array(
            'user'  => \yii::app()->user->getInstance(),
            'teams' => $teams,
            'year'  => $year,
        ));
    }

    /**
     * Method which shows the information about
     */
    public function actionView()
    {
        // Get params
        $teamId = $this->request->getParam('id');

        // Get team
        $team = Team::model()->findByPk(new \MongoId($teamId));
        if ($team === null) {
            $this->httpException(404);
        }

        // Render view
        $this->render('view', array(
            'team'    => $team,
            'coach'   => $team->coach,
            'members' => $team->members
        ));
    }

}