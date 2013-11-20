<?php

namespace web\controllers;

use \common\models\Document;
use common\models\Geo\Region;
use \common\models\Geo\State;
use common\models\Result;
use common\models\School;

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
        // Get list of results
        $criteria1 = new \EMongoCriteria();
        $criteria1
            ->addCond('type', '==', Document::TYPE_RESULTS_PHASE_1)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $phase1 = Document::model()->findAll($criteria1);
        $criteria2 = new \EMongoCriteria();
        $criteria2
            ->addCond('type', '==', Document::TYPE_RESULTS_PHASE_2)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $phase2 = Document::model()->findAll($criteria2);
        $criteria3 = new \EMongoCriteria();
        $criteria3
            ->addCond('type', '==', Document::TYPE_RESULTS_PHASE_3)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        $phase3 = Document::model()->findAll($criteria3);

        // Render view
        $this->render('latest', array(
            'states'  => State::model()->getConstantList('NAME_'),
            'regions' => Region::model()->getConstantList('NAME_')
        ));
    }

    /**
     * View results of some phase and state/region/country
     */
    public function actionView()
    {
        $year  = (int)$this->request->getParam('year');
        $phase = (int)$this->request->getParam('phase');
        if (($year === 0) || $phase === 0) {
            $this->httpException(404);
        }
        switch ($phase) {
            case 1:
                $geo    = $this->request->getParam('state');
                $header = State::model()->getAttributeLabel($geo, 'name');
                break;
            case 2:
                $geo = $this->request->getParam('region');
                $header = Region::model()->getAttributeLabel($geo, 'name');
                break;
            case 3:
                $geo = $this->request->getParam('country');
                $header = School::getCountryLabel();
                break;
            default:
                $this->httpException(404);
                break;
        }

        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('year',  '==', $year)
            ->addCond('phase', '==', $phase)
            ->addCond('geo',   '==', $geo)
            ->sort('place', \EMongoCriteria::SORT_ASC);


        $results    = Result::model()->findAll($criteria);
        $result     = Result::model()->find($criteria);
        $tasksCount = (isset($result)) ? count($result->tasksTries) : 0;

        $this->render('view', array(
            'header'     => $header,
            'year'       => $year,
            'phase'      => $phase,
            'results'    => $results,
            'tasksCount' => $tasksCount
        ));
    }

}