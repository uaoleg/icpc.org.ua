<?php

namespace web\modules\staff\controllers;

use \common\models\News;

class NewsController extends \web\modules\staff\ext\Controller
{

    /**
     * Edit page
     */
    public function actionEdit()
    {
        // Get params
        $id         = $this->request->getParam('id', '');
        $lang       = $this->request->getParam('lang', \yii::app()->language);
        $title      = $this->request->getPost('title', '');
        $content    = $this->request->getPost('content', '');

        // Get news
        $news = News::model()->findByAttributes(array(
            'commonId'  => $id,
            'lang'      => $lang,
        ));
        if ($news === null) {
            if ((!empty($id)) && (News::model()->countByAttributes(array('commonId' => $id)) === 0)) {
                return $this->httpException(404);
            } else {
                $news = new News();
                $news->setAttributes(array(
                    'commonId'  => $id,
                    'lang'      => $lang,
                ), false);
            }
        }

        // Save news
        if ($this->request->isPostRequest) {
            $isNew = empty($news->commonId);
            $news->setAttributes(array(
                'lang'      => $lang,
                'title'     => $title,
                'content'   => $content,
            ), false);
            $news->save();
            $this->renderJson(array(
                'isNew'     => $isNew,
                'errors'    => $news->hasErrors() ? $news->getErrors() : false,
                'url'       => $this->createUrl('edit', array(
                    'id'    => $news->commonId,
                    'lange' => $news->lang,
                )),
            ));
        }

        // Render view
        else {
            $this->render('edit', array(
                'news' => $news,
            ));
        }
    }

    /**
     * Publish or hide news
     */
    public function actionPublish()
    {
        // Get params
        $commonId   = $this->request->getParam('id');
        $status     = (bool)$this->request->getParam('status');

        // Get list of news
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('commonId', '==', $commonId)
            ->addCond('isPublished', '!=', $status);
        $newsList = News::model()->findAll($criteria);

        // Change status
        foreach ($newsList as $news) {
            $news->isPublished = $status;
            $news->save();
        }

        // Render json
        $this->renderJson(array(
            'errors'    => ($news->hasErrors()) ? $news->getErrors() : false,
        ));
    }

}