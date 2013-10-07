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
        $id     = $this->request->getParam('id');
        $status = (bool)$this->request->getParam('status');

        // Get news
        $news = News::model()->findByPk(new \MongoId($id));
        $news->isPublished = $status;
        $news->save();
        $this->renderJson(array(
            'id'        => (string)$news->_id,
            'errors'    => ($news->hasErrors()) ? $news->getErrors() : false,
        ));
    }

}