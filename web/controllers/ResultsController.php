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
        // Render view
        $this->render('latest', array(
            'states'  => Geo\State::model()->getConstantList('NAME_'),
            'regions' => Geo\Region::model()->getConstantList('NAME_')
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
            'header'    => $header,
            'year'      => $year,
            'phase'     => $phase,
            'results'   => $results,
            'tasksCount'=> $tasksCount,
            'letters'   => Result::TASKS_LETTERS,
        ));
    }

}