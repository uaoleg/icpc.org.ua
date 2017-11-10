<?php

namespace frontend\modules\staff\controllers;

use \common\models\Result;
use \common\models\School;
use \common\models\Team;

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

        // Get teams
        $teams = Team::find()
            ->alias('team')
            ->innerJoin(['result' => Result::tableName()], 'result.teamId = team.id')
            ->innerJoin(['school' => School::tableName()], 'school.id = team.schoolId')
            ->andWhere([
                'result.phase' => $phase,
                'result.geo'   => $geo,
                'result.year'  => $year,
            ])
            ->orderBy('school.fullNameUk')
            ->groupBy('team.id')
            ->all()
        ;

        // Render view
        $this->layout = 'report';
        return $this->render('participants', array(
            'teams' => $teams,
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
                'teamName'   => $result->team ? $result->team->name : $result->teamName,
                'schoolName' => $result->team ? $result->team->school->fullNameUk : '',
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
