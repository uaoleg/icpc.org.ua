<?php

namespace web\controllers;

use \common\models\News;

class NewsController extends \web\ext\Controller
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
        $this->setNavActiveItem('main', 'news');
    }

    /**
     * Lates news
     */
    public function actionLatest()
    {
        // Get params
        $page       = (int)$this->request->getParam('page', 1);
        $perPage    = 5;
        if ($page < 1) {
            $page = 1;
        }

        // Get list of news
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('lang', '==', \yii::app()->language)
            ->sort('dateCreated', \EMongoCriteria::SORT_DESC)
            ->offset(($page - 1) * $perPage)
            ->limit($perPage);
        if (!\yii::app()->user->checkAccess('newsUpdate')) {
            $criteria->addCond('isPublished', '==', true);
        }
        $newsList = News::model()->findAll($criteria);
        $newsCount  = $newsList->count(true);
        $totalCount = $newsList->count(false);
        $pageCount  = ceil($totalCount / $perPage);
        if (($newsCount === 0) && ($page > 1) && ($page > $pageCount)) {
            return $this->redirect(array('latest', 'page' => 1));
        }

        // Render view
        $this->render('latest', array(
            'newsList'      => $newsList,
            'page'          => $page,
            'newsCount'     => $newsCount,
            'totalCount'    => $totalCount,
            'pageCount'     => $pageCount,
        ));
    }

    /**
     * View news item page
     */
    public function actionView()
    {
        // Get params
        $id     = $this->request->getParam('id');
        $lang   = $this->request->getParam('lang');

        // Get news
        $news = News::model()->findByAttributes(array(
            'commonId'  => $id,
            'lang'      => empty($lang) ? \yii::app()->language : $lang,
        ));
        if ($news === null) {
            return $this->httpException(404);
        }
        if (!\yii::app()->user->checkAccess('newsRead', array('news' => $news))) {
            return $this->httpException(403);
        }

        // Render view
        $this->render('view', array(
            'news' => $news,
        ));
    }

}