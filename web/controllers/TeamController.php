<?php

namespace web\controllers;

use \common\models\Team;
use \common\models\User;
use \common\models\School;

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
        $this->setNavActiveItem('main', '');
    }

    public function actionList()
    {
        $criteria = new \EMongoCriteria();
        $criteria->sort('name', \EMongoCriteria::SORT_ASC);
        $teams = Team::model()->findAll($criteria);
        $this->render('list', array(
            'teams' => $teams
        ));
    }

    /**
     * Manage the team
     * either create or edit it
     */
    public function actionManage()
    {
        $school = \yii::app()->user->getInstance()->getSchool();
        if ($this->request->isAjaxRequest && $this->request->isPostRequest) {

            $shortNameUk = $this->request->getPost('shortNameUk');
            $fullNameEn  = $this->request->getPost('fullNameEn');
            $shortNameEn = $this->request->getPost('shortNameEn');
            $school->setAttributes(array(
                'shortNameUk'  => $shortNameUk,
                'fullNameEn'   => $fullNameEn,
                'shortNameEn'  => $shortNameEn
            ), false);
            $school->save();

            $teamName = $this->request->getPost('teamNamePrefix');
            $team = Team::model()->findByPk(new \MongoId($this->request->getPost('teamId')));
            $team = (isset($team)) ? $team : new Team();
            $team->setAttributes(array(
                'name' => $teamName,
                'year' => date('Y'),
                'schoolId' => (string)$school->_id,
                'coachId' => \yii::app()->user->id,
                'members' => array(
                    0 => $this->request->getPost('member1'),
                    1 => $this->request->getPost('member2'),
                    2 => $this->request->getPost('member3'),
                    3 => $this->request->getPost('member4')
                )
            ), false);
            $team->save();

            $this->renderJson(array(
                'errors' => $team->hasErrors() ? $team->getErrors() : false
            ));

        } else {
            $team = Team::model()->findByPk(new \MongoId($this->request->getParam('id')));
            $members = User::model()->findAll(array('schoolId' => (string)$school->_id));
            $this->render('manage', array(
                'school'  => $school,
                'members' => $members,
                'team'    => (isset($team)) ? $team : new Team(),
                'teamMembers' => array(
                    (isset($team)) ? $team->members[0] : '',
                    (isset($team)) ? $team->members[1] : '',
                    (isset($team)) ? $team->members[2] : '',
                    (isset($team)) ? $team->members[3] : '',
                )
            ));
        }
    }

    /**
     * Method which shows the information about
     */
    public function actionView()
    {
        $teamId = $this->request->getParam('id');
        if (isset($teamId)) {
            $team   = Team::model()->findByPk(new \MongoId($teamId));

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
        } else {
            return $this->httpException(404);
        }
    }

}