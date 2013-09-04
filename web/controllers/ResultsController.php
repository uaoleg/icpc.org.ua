<?php

namespace web\controllers;

use \common\models\Document;

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
            'phase1' => $phase1,
            'phase2' => $phase2,
            'phase3' => $phase3,
        ));
    }

}