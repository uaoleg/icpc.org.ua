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
        $geo        = $this->request->getPost('geo');

        // Get news
        $news = News::model()->findByAttributes(array(
            'commonId'  => $id,
            'lang'      => $lang,
        ));
        if ($news === null) {
            if ((!empty($id)) && (News::model()->countByAttributes(array('commonId' => $id)) === 0)) {
                return $this->httpException(404);
            } else {
                $relatedNews = News::model()->findByAttributes(array('commonId' => $id));
                $news = new News();
                $news->setAttributes(array(
                    'commonId'  => $id,
                    'lang'      => $lang,
                    'geo'       => $relatedNews ? $relatedNews->geo : '',
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
                'geo'       => $geo,
            ), false);
            $news->save();

            // Set geo attribute for all related news
            $modifier = new \EMongoModifier();
            $modifier->addModifier('geo', 'set', $geo);
            $criteria = new \EMongoCriteria();
            $criteria->addCond('commonId', '==', $id);
            News::model()->updateAll($modifier, $criteria);

            // Render json
            $this->renderJson(array(
                'isNew'     => $isNew,
                'errors'    => $news->hasErrors() ? $news->getErrors() : false,
                'url'       => $this->createUrl('edit', array(
                    'id'    => $news->commonId,
                    'lang'  => $news->lang,
                )),
            ));
        }

        // Render view
        else {
            $this->render('edit', array(
                'news'       => $news,
                'newsImages' => $news->imagesIds
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

    /**
     * Action to delete image from news
     */
    public function actionDeleteImage()
    {
        $imageId = $this->request->getParam('imageId');
        $image = News\Image::model()->findByPk(new \MongoId($imageId));
        $image->delete();
    }

}