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

    public function actionCreate()
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
            ));
            $school->save();

            $teamName = $this->request->getPost('teamNamePrefix');
            $team = new Team();
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
            ));
            $team->save();

            $this->renderJson(array(
                'errors' => $team->hasErrors() ? $team->getErrors() : false
            ));

        } else {
            $members = User::model()->findAll(array('schoolId' => (string)$school->_id));
            $this->render('create', array(
                'school'  => $school,
                'members' => $members
            ));
        }
    }

}