<?php

namespace web\modules\staff\controllers;

use \common\models\Team;
use \common\models\Result;

class ReportsController extends \web\modules\staff\ext\Controller
{

    public function actionIndex()
    {
        $this->render('index', array('year' => $this->year));
    }

    public function actionParticipants()
    {
        $participants = array();

        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('phase', '==', Result::PHASE_3)
            ->addCond('year', '==', $this->year)
            ->sort('schoolNameUk', \EMongoCriteria::SORT_ASC);
        $teams = Team::model()->findAll($criteria);

        foreach ($teams as $team) {
            $participant = array(
                'schoolNameUk' => $team->schoolNameUk,
                'schoolNameEn' => $team->schoolNameEn,
                'teamName'     => $team->name,
                'coach'        => $team->coach,
            );
            foreach ($team->members as $member) {
                $participant['members'][] = $member;
            }
            $participants[] = $participant;
        }

        $this->layout = false;
        $this->render('participants', array(
            'participants' => $participants
        ));
    }

    public function actionWinners()
    {
        $winners = array();

        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('phase', '==', Result::PHASE_3)
            ->addCond('year', '==', $this->year)
            ->sort('place', \EMongoCriteria::SORT_ASC);
        $results = Result::model()->findAll($criteria);
        foreach ($results as $result) {
            $winner = array(
                'place'      => $result->place,
                'teamName'   => $result->teamName,
                'schoolName' => $result->schoolNameUk,
                'tasks'      => $result->total,
                'totalTime'  => $result->penalty,
                'members'    => array(),
                'coach'      => null
            );
            if (isset($result->teamId)) {
                $team = Team::model()->findByPk(new \MongoId($result->teamId));
                foreach ($team->members as $member) {
                    $winner['members'][] = $member;
                }
                $winner['coach'] = $team->coach;
            }
            $winners[] = $winner;
        }

        $this->layout = false;
        $this->render('winners', array(
            'winners' => $winners
        ));
    }

}