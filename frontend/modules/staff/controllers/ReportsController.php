<?php

namespace frontend\modules\staff\controllers;

use \common\models\Result;

class ReportsController extends \frontend\modules\staff\ext\Controller
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
        $phase = (int)\yii::$app->request->get('phase');
        $geo   = \yii::$app->request->get('geo');
        $year  = (int)\yii::$app->request->get('year');

        // Get list of results
        $results = Result::find()
            ->andWhere([
                'phase' => $phase,
                'geo'   => $geo,
                'year'  => $year,
            ])
            ->orderBy('schoolNameUk')
            ->all()
        ;

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
                'schoolNameUk' => $team->school->fullNameUk,
                'schoolNameEn' => $team->school->fullNameEn,
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
        return $this->render('participants', array(
            'participants' => $participants,
        ));
    }

    /**
     * Report of winners
     */
    public function actionWinners()
    {
        $phase = (int)\yii::$app->request->get('phase');
        $geo   = \yii::$app->request->get('geo');
        $year  = (int)\yii::$app->request->get('year');

        // Get list of results
        $results = Result::find()
            ->andWhere([
                'phase' => $phase,
                'geo'   => $geo,
                'year'  => $year,
            ])
            ->orderBy('place')
            ->all()
        ;

        // Create list of winners
        $winners = array();
        foreach ($results as $result) {
            $winner = array(
                'place'      => $result->placeText,
                'teamName'   => $result->team->name,
                'schoolName' => $result->school->fullNameUk,
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
        return $this->render('winners', array(
            'winners' => $winners
        ));
    }

}
