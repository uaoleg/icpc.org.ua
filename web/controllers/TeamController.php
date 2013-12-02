<?php

namespace web\controllers;

use \common\models\Team;

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
     * Method which shows the information about team
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

    /**
     * Method for jqGrid which returns all the items to be shown
     */
    public function actionGetTeamListJson()
    {
        $lang = \yii::app()->language;
        // Get jqGrid params
        $criteria = new \EMongoCriteria();
        $criteria->addCond('year', '==', (int)$this->getYear());
        $jqgrid = $this->_getJqgridParams(Team::model(), $criteria);

        // Fill rows
        $rows = array();
        foreach ($jqgrid['itemList'] as $team) {
            $members = $team->members;
            $members_arr = array();
            foreach ($members as $member) {
                $members_arr[] = \web\widgets\user\Name::create(array('user' => $member), true);
            }
            $members_str = implode(', ', $members_arr);
            $rows[] = array(
                'id'                            => (string)$team->_id,
                'name'                          => $team->name,
                'schoolName'.ucfirst($lang)     => $team->schoolName,
                'coachName'.ucfirst($lang)      => $team->coachName,
                'members'                       => $members_str,
                'year'                          => $team->year
            );
        }
        $this->renderJson(array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
        ));
    }

}