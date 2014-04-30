<?php

namespace web\modules\staff\controllers;

use \common\models\Result;

class ReportsController extends \web\modules\staff\ext\Controller
{

    /**
     * All the rules of access to methods of this controller
     * @return array
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'roles' => array(\common\models\User::ROLE_COORDINATOR_STATE),
            ),
            array(
                'deny',
            )
        );
    }

    /**
     * Report of participants
     */
    public function actionParticipants()
    {
        // Get params
        $phase = (int)\yii::app()->request->getParam('phase');
        $geo   = \yii::app()->request->getParam('geo');
        $year  = (int)\yii::app()->request->getParam('year');

        // Get list of results
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('phase', '==', $phase)
            ->addCond('geo', '==', $geo)
            ->addCond('year', '==', $year)
            ->sort('schoolNameUk', \EMongoCriteria::SORT_ASC);
        $results = Result::model()->findAll($criteria);

        // Get teams
        $teams = array();
        foreach ($results as $result) {
            if ($result->team !== null) {
                $teams[] = $result->team;
            }
        }

        // Create list of participants
        $participants = array();
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

        // Render view
        $this->layout = 'report';
        $this->render('participants', array(
            'participants' => $participants,
        ));
    }

    /**
     * Report of winners
     */
    public function actionWinners()
    {
        $phase = (int)\yii::app()->request->getParam('phase');
        $geo   = \yii::app()->request->getParam('geo');
        $year  = (int)\yii::app()->request->getParam('year');

        // Get list of results
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('phase', '==', $phase)
            ->addCond('geo', '==', $geo)
            ->addCond('year', '==', $year)
            ->sort('place', \EMongoCriteria::SORT_ASC);
        $results = Result::model()->findAll($criteria);

        // Create list of winners
        $winners = array();
        foreach ($results as $result) {
            $winner = array(
                'place'      => $result->placeText,
                'teamName'   => $result->teamName,
                'schoolName' => $result->schoolNameUk,
                'tasks'      => $result->total,
                'totalTime'  => $result->penalty,
                'members'    => array(),
                'coach'      => null,
            );
            if ($result->team !== null) {
                foreach ($result->team->members as $member) {
                    $winner['members'][] = $member;
                }
                $winner['coach'] = $result->team->coach;
            }
            $winners[] = $winner;
        }

        // Render view
        $this->layout = 'report';
        $this->render('winners', array(
            'winners' => $winners
        ));
    }

}
