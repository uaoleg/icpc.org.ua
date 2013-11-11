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
        // Get list of teams
        $criteria = new \EMongoCriteria();
        $criteria
            ->sort('name', \EMongoCriteria::SORT_ASC)
            ->sort('year', \EMongoCriteria::SORT_DESC);
        $teams = Team::model()->findAll($criteria);

        // Render view
        $this->render('list', array(
            'user'  => \yii::app()->user->getInstance(),
            'teams' => $teams
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
            'school'  => $team->school,
            'coach'   => $team->coach,
            'members' => array(
                User::model()->findByPk(new \MongoId($team->members[0])),
                User::model()->findByPk(new \MongoId($team->members[1])),
                User::model()->findByPk(new \MongoId($team->members[2])),
                User::model()->findByPk(new \MongoId($team->members[3])),
            )
        ));
    }

}