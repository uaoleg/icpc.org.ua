<?php

namespace frontend\controllers;

use \common\models\Geo;
use \common\models\Result;
use \common\models\School;
use \frontend\search\ResultSearch;
use \yii\helpers\ArrayHelper;

class ResultsController extends BaseController
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'latest';

        // Set active main menu item
        $this->setNavActiveItem('main', 'results');
    }

    /**
     * Latest results page
     */
    public function actionLatest()
    {
        // Get params
        $year = $this->getYear();

        // Select states for which there are results
        $results = Result::find()
            ->distinct('geo')
            ->andWhere([
                'year'  => $year,
                'geo'   => array_values(Geo\State::getConstants('NAME_'))
            ])
            ->asArray()
            ->all()
        ;
        $states = ArrayHelper::getColumn($results, 'geo');

        $statesWithLabels = array();
        foreach ($states as $state) {
            $statesWithLabels[$state] = Geo\State::getConstantLabel($state);
        }
        asort($statesWithLabels);

        // Select regions for which there are results
        $results = Result::find()
            ->distinct('geo')
            ->andWhere([
                'year'  => $year,
                'geo'   => array_values(Geo\Region::getConstants('NAME_'))
            ])
            ->asArray()
            ->all()
        ;
        $regions = ArrayHelper::getColumn($results, 'geo');

        $regionsWithLabels = array();
        foreach ($regions as $region) {
            $regionsWithLabels[$region] = Geo\Region::getConstantLabel($region);
        }

        // Check if there are results for 3rd phase
        $hasUkraineResults = false;
        if (Result::findOne([
            'year' => $year,
            'geo'  => (new School)->getCountry(),
        ]) !== null) {
            $hasUkraineResults = true;
        }

        // Render view
        return $this->render('latest', array(
            'year'              => $year,
            'states'            => $statesWithLabels,
            'regions'           => $regionsWithLabels,
            'hasUkraineResults' => $hasUkraineResults,
        ));
    }

    /**
     * View results of some phase and state/region/country
     */
    public function actionView()
    {
        // Get params
        $year  = (int)\yii::$app->request->get('year');
        $phase = (int)\yii::$app->request->get('phase');
        if (($year === 0) || $phase === 0) {
            $this->httpException(404);
        }
        switch ($phase) {
            case Result::PHASE_1:
                $geo    = \yii::$app->request->get('state');
                $header = Geo\State::getConstantLabel($geo);
                break;
            case Result::PHASE_2:
                $geo    = \yii::$app->request->get('region');
                $header = Geo\Region::getConstantLabel($geo);
                break;
            case Result::PHASE_3:
                $geo    = \yii::$app->request->get('country');
                $header = (new School)->getCountryLabel();
                break;
            default:
                $this->httpException(404);
                break;
        }
        if (empty($header)) {
            $this->httpException(404);
        }

//        // Cols
//        foreach ($result->tasks as $task) {
//            $arrayToAdd[$task->letter] = $task->triesCount;
//            if ($task->triesCount > 0) {
//                $datetime = new \DateTime();
//                $datetime->setTime(0, 0, $task->secondsSpent);
//                $arrayToAdd[$task->letter] .= '&nbsp;(' . $datetime->format('G:i') . ')';
//            }
//        }

        // Get list of results
        $resultsSearch = new ResultSearch([
            'year'  => $year,
            'phase' => $phase,
            'geo'   => $geo,
        ]);
        $resultsProvider = $resultsSearch->search(\yii::$app->request->queryParams);

        // Render view
        return $this->render('view', array(
            'resultsProvider'   => $resultsProvider,
            'resultsSearch'     => $resultsSearch,
            'geo'         => $geo,
            'header'      => $header,
            'year'        => $year,
            'phase'       => $phase,
            'lang'        => \yii::$app->user->languageCore,
        ));
    }

    /**
     * Method for jqGrid which returns all the results to be shown
     */
    public function actionGetResultsListJson()
    {
        // Get params
        $year   = (int)\yii::$app->request->get('year');
        $geo    = \yii::$app->request->get('geo');
        $lang   = \yii::$app->user->languageCore;

        // Get jqGrid params
        $query = Result::find()
            ->andWhere([
                'year'  => $year,
                'geo'   => $geo,
            ])
            ->orderBy('prizePlace')
        ;
        $jqgrid = $this->_getJqgridParams(Result::class, $query);

        // Fill rows
        $rows = array();
        foreach ($jqgrid['itemList'] as $result) {
            $arrayToAdd = array(
                'id'                        => $result->id,
                'place'                     => $this->render('view/place', array('result' => $result)),
                'teamName'                  => $this->render('view/team-name', array('result' => $result)),
                'coachId'                   => $result->coachId,
                'schoolName'.ucfirst($lang) => $result->school->fullName,
                'coachName'.ucfirst($lang)  => $result->coachName,
                'total'                     => $result->total,
                'penalty'                   => $result->penalty
            );
            foreach ($result->tasks as $task) {
                $arrayToAdd[$task->letter] = $task->triesCount;
                if ($task->triesCount > 0) {
                    $datetime = new \DateTime();
                    $datetime->setTime(0, 0, $task->secondsSpent);
                    $arrayToAdd[$task->letter] .= '&nbsp;(' . $datetime->format('G:i') . ')';
                }
            }
            $rows[] = $arrayToAdd;
        }
        return $this->renderJson(array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
        ));
    }

}