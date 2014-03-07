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
        $geo        = $this->getGeo();
        $year       = $this->getYear();
        $page       = (int)$this->request->getParam('page', 1);
        $perPage    = 5;
        $publishedOnly = !\yii::app()->user->checkAccess(\common\components\Rbac::OP_NEWS_CREATE);

        // Page range
        if ($page < 1) {
            $page = 1;
        }

        // Get list of news
        $newsList = News::model()
            ->scopeByLatest($geo, $year, $publishedOnly, $page, $perPage)
            ->findAll();
        $newsCount  = $newsList->count(true);
        $totalCount = $newsList->count(false);
        $pageCount  = ceil($totalCount / $perPage);
        if (($newsCount === 0) && ($page > 1) && ($page > $pageCount)) {
            return $this->redirect(array('latest', 'page' => 1));
        }

        // Render view
        $this->render('latest', array(
            'newsList'      => $newsList,
            'geo'           => $geo,
            'year'          => $year,
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
        $lang   = $this->request->getParam('lang', \yii::app()->language);

        // Get news
        $news = News::model()->findByAttributes(array(
            'commonId'  => $id,
            'lang'      => $lang,
        ));

        // If news was not found
        if ($news === null) {

            // Check it on other languages
            $newsList = News::model()->findAllByAttributes(array(
                'commonId' => $id,
            ));
            if (count($newsList) > 0) {
                $this->render('viewOtherLang', array(
                    'lang'      => $lang,
                    'newsList'  => $newsList,
                ));
                return;
            } else {
                return $this->httpException(404);
            }
        }

        // Check access
        if (!\yii::app()->user->checkAccess(\common\components\Rbac::OP_NEWS_READ, array('news' => $news))) {
            return $this->httpException(403);
        }

        // Render view
        $this->render('view', array(
            'news' => $news,
            'imagesIds' => $news->imagesIds
        ));
    }

    public function actionImage()
    {
        // Get params
        $imageId = $this->request->getParam('id');

        // Get document
        $image = News\Image::model()->findByPk(new \MongoId($imageId));
        if ($image === null) {
            return $this->httpException(404);
        }

        // Download file
        header('Content-type: image/jpeg');
        header('Content-Disposition: attachment; filename="' . $image->fileName . '"');

        echo $image->file->getBytes();
    }

}