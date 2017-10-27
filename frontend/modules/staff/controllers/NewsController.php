<?php

namespace frontend\modules\staff\controllers;

use \common\models\News;
use \yii\helpers\Url;

class NewsController extends \frontend\modules\staff\ext\Controller
{

    /**
     * Edit page
     */
    public function actionEdit()
    {
        // Get params
        $id         = \yii::$app->request->get('id', '');
        $lang       = \yii::$app->request->get('lang', \yii::$app->language);
        $title      = \yii::$app->request->post('title', '');
        $content    = \yii::$app->request->post('content', '');
        $geo        = \yii::$app->request->post('geo');

        // Get news
        $news = News::findOne([
            'commonId'  => $id,
            'lang'      => $lang,
        ]);
        if ($news === null) {
            if ((!empty($id)) && (News::findOne(['commonId' => $id]) === null)) {
                return $this->httpException(404);
            } else {
                $relatedNews = News::findAll(['commonId' => $id]);
                $news = new News();
                $news->setAttributes(array(
                    'commonId'  => $id,
                    'lang'      => $lang,
                    'geo'       => $relatedNews ? $relatedNews->geo : '',
                ), false);
            }
        }

        // Save news
        if (\yii::$app->request->isPost) {
            $isNew = empty($news->commonId);
            $news->setAttributes(array(
                'lang'      => $lang,
                'title'     => $title,
                'content'   => $content,
                'geo'       => $geo,
            ), false);
            $news->save();

            // Set geo attribute for all related news
            News::updateAll([
                'geo' => $geo,
            ], [
                'commonId' => $id,
            ]);

            // Set news id for all downloaded images
            News\Image::updateAll([
                'newsId' => $news->commonId,
            ], [
                'newsId' => null,
                'userId' => \yii::$app->user->id,
            ]);

            // Render json
            return $this->renderJson(array(
                'isNew'     => $isNew,
                'errors'    => $news->hasErrors() ? $news->getErrors() : false,
                'url'       => Url::toRoute([
                    'edit',
                    'id'    => $news->commonId,
                    'lang'  => $news->lang,
                ]),
            ));
        }

        // Render view
        else {
            return $this->render('edit', array(
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
        $commonId   = \yii::$app->request->post('id');
        $status     = (bool)\yii::$app->request->post('status');

        // Get list of news
        $newsList = News::find()
            ->andWhere(['commonId' => $commonId])
            ->andWhere(['!=', 'isPublished', $status])
            ->all()
        ;

        // Change status
        foreach ($newsList as $news) {
            $news->isPublished = $status;
            $news->save();
        }

        // Render json
        return $this->renderJson(array(
            'errors'    => ($news->hasErrors()) ? $news->getErrors() : false,
        ));
    }

    /**
     * Action to delete image from news
     */
    public function actionDeleteImage()
    {
        $imageId = \yii::$app->request->get('imageId');
        $image = News\Image::findOne($imageId);
        $image->delete();
    }

}