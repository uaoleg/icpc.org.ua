<?php

namespace frontend\controllers;

use \common\models\News;

class NewsController extends BaseController
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
     * Latest news
     */
    public function actionLatest()
    {
        // Get params
        $geo        = $this->getGeo();
        $year       = $this->getYear();
        $page       = (int)\yii::$app->request->get('page', 1);
        $perPage    = 5;
        $publishedOnly = !\yii::$app->user->can(\common\components\Rbac::OP_NEWS_CREATE);

        // Page range
        if ($page < 1) {
            $page = 1;
        }

        // Get list of news
        $newsQuery = News::find()
            ->andWhere([
                'lang'          => \yii::$app->language,
                'geo'           => $geo,
                'yearCreated'   => $year,
            ])
            ->orderBy('timeCreated DESC')
            ->offset(($page - 1) * $perPage)
        ;
        if ($publishedOnly) {
            $newsQuery->andWhere(['isPublished' => true]);
        }
        $newsCount  = $newsQuery->count();
        $newsQuery->limit($perPage);
        $newsList = $newsQuery->all();
        $totalCount = $newsQuery->count();
        $pageCount  = ceil($totalCount / $perPage);
        if (($newsCount === 0) && ($page > 1) && ($page > $pageCount)) {
            return $this->redirect(array('latest', 'page' => 1));
        }

        // Render view
        return $this->render('latest', array(
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
        $id     = \yii::$app->request->get('id');
        $lang   = \yii::$app->request->get('lang', \yii::$app->language);

        // Get news
        $news = News::findOne([
            'commonId'  => $id,
            'lang'      => $lang,
        ]);

        // If news was not found
        if ($news === null) {

            // Check it on other languages
            $newsList = News::findAll(['commonId' => $id]);
            if (count($newsList) > 0) {
                return $this->render('view-other-lang', array(
                    'lang'      => $lang,
                    'newsList'  => $newsList,
                ));
                return;
            } else {
                return $this->httpException(404);
            }
        }

        // Check access
        if (!\yii::$app->user->can(\common\components\Rbac::OP_NEWS_READ, array('news' => $news))) {
            return $this->httpException(403);
        }

        // Render view
        return $this->render('view', array(
            'news' => $news,
            'imagesIds' => $news->imagesIds
        ));
    }

    /**
     * Render image
     */
    public function actionImage($id)
    {
        // Get document
        $image = News\Image::findOne($id);
        if ($image === null) {
            $this->httpException(404);
        }

        // Send headers
        header('Content-type: image/jpeg');
        header('Cache-Control: public, max-age=' . SECONDS_IN_YEAR . ', pre-check=' . SECONDS_IN_YEAR);
        header('Pragma: public');
        header('Expires: ' . gmdate(DATE_RFC1123, time() + SECONDS_IN_YEAR));
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            header('HTTP/1.1 304 Not Modified');
            exit;
        }

        // Send content
        echo $image->content;
    }

}