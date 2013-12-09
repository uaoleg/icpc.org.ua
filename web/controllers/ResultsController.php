<?php

namespace web\controllers;

use \common\models\Geo;
use \common\models\Result;
use \common\models\School;

class ResultsController extends \web\ext\Controller
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
        $states = Result::model()->getCollection()->distinct('geo',  array(
            'year'  => $year,
            'geo'   => array('$in' => Geo\State::model()->getConstantList('NAME_'))
        ));

        // Select regions for which there are results
        $regions = Result::model()->getCollection()->distinct('geo', array(
            'year' => $year,
            'geo'  => array('$in' => Geo\Region::model()->getConstantList('NAME_'))
        ));

        // Check if there are results for 3rd phase
        $hasUkraineResults = false;
        if (count(Result::model()->findAllByAttributes(array(
                'year' => $year,
                'geo'  => \yii::app()->user->getInstance()->school->getCountry()
            ))) > 0) {
            $hasUkraineResults = true;
        }

        // Render view
        $this->render('latest', array(
            'year'              => $year,
            'states'            => $states,
            'regions'           => $regions,
            'hasUkraineResults' => $hasUkraineResults,
            'school'            => \yii::app()->user->getInstance()->school
        ));
    }

    /**
     * View results of some phase and state/region/country
     */
    public function actionView()
    {
        // Get params
        $year  = (int)$this->request->getParam('year');
        $phase = (int)$this->request->getParam('phase');
        if (($year === 0) || $phase === 0) {
            $this->httpException(404);
        }
        switch ($phase) {
            case Result::PHASE_1:
                $geo    = $this->request->getParam('state');
                $header = Geo\State::model()->getAttributeLabel($geo, 'name');
                break;
            case Result::PHASE_2:
                $geo    = $this->request->getParam('region');
                $header = Geo\Region::model()->getAttributeLabel($geo, 'name');
                break;
            case Result::PHASE_3:
                $geo    = $this->request->getParam('country');
                $header = School::getCountryLabel();
                break;
            default:
                $this->httpException(404);
                break;
        }
        if (empty($header)) {
            $this->httpException(404);
        }

        // Get the list of results
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('year',  '==', $year)
            ->addCond('phase', '==', $phase)
            ->addCond('geo',   '==', $geo)
            ->sort('place', \EMongoCriteria::SORT_ASC);
        $results    = Result::model()->findAll($criteria);
        $result     = Result::model()->find($criteria);
        $tasksCount = ($result !== null) ? count($result->tasksTries) : 0;

        // Render view
        $this->render('view', array(
            'geo'       => $geo,
            'header'    => $header,
            'year'      => $year,
            'phase'     => $phase,
            'results'   => $results,
            'tasksCount'=> $tasksCount,
            'letters'   => Result::TASKS_LETTERS,
        ));
    }

    /**
     * Method for jqGrid which returns all the results to be shown
     */
    public function actionGetResultsListJson()
    {
        $lang = \yii::app()->language;

        // Get jqGrid params
        $criteria = new \EMongoCriteria();
        $criteria->addCond('year', '==', (int)$this->getYear());
        $criteria->addCond('geo', '==', $this->request->getParam('geo'));
        $jqgrid = $this->_getJqgridParams(Result::model(), $criteria);

        // Fill rows
        $rows = array();
        foreach ($jqgrid['itemList'] as $result) {
            $arrayToAdd = array(
                'id'                        => $result->teamId,
                'place'                     => $result->place,
                'teamName'                  => $result->teamName,
                'schoolName'.ucfirst($lang) => $result->schoolName,
                'coachName'.ucfirst($lang)  => $result->coachName,
                'total'                     => $result->total,
                'penalty'                   => $result->penalty
            );
            foreach ($result->tasksTries as $letter => $tries) {
                if (isset($tries)) {
                    $arrayToAdd[$letter] = $tries;
                    if ($tries > 0) {
                        $arrayToAdd[$letter] .= '&nbsp;(' . gmdate("H:i", $result->tasksTime[$letter]) . ')';
                    }
                }
            }
            $rows[] = $arrayToAdd;
        }
        $this->renderJson(array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
        ));
    }

}