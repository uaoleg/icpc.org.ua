<?php

namespace web\modules\staff\controllers;

use \common\models\News;

class NewsController extends \web\modules\staff\ext\Controller
{

    /**
     * Create page
     */
    public function actionCreate()
    {
        // Get params
        $lang       = $this->request->getParam('lang');
        $title      = $this->request->getPost('title');
        $content    = $this->request->getPost('content');

        // Create news
        $news = new News();

        // Save news
        if ($this->request->isPostRequest) {
            $news->setAttributes(array(
                'lang'      => $lang,
                'title'     => $title,
                'content'   => $content,
            ), false);
            $news->save();
            $errors = $news->getErrors();
            $this->renderJson(array(
                'id'        => (string)$news->_id,
                'errors'    => count($errors) > 0 ? $errors : false,
            ));
        }

        // Render view
        else {
            $this->render('create', array(
                'news' => $news,
            ));
        }
    }

    /**
     * Edit page
     */
    public function actionEdit()
    {
        // Get params
        $id         = $this->request->getParam('id');
        $lang       = $this->request->getParam('lang');
        $title      = $this->request->getPost('title');
        $content    = $this->request->getPost('content');

        // Get news
        $news = News::model()->findByAttributes(array(
            'commonId'  => $id,
            'lang'      => $lang,
        ));
        if ($news === null) {
            if (News::model()->countByAttributes(array('commonId' => $id)) === 0) {
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
            $news->setAttributes(array(
                'lang'      => $lang,
                'title'     => $title,
                'content'   => $content,
            ), false);
            $news->save();
            $errors = $news->getErrors();
            $this->renderJson(array(
                'id'        => (string)$news->_id,
                'errors'    => count($errors) > 0 ? $errors : false,
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
        $errors = $news -> getErrors();
        $this -> renderJson(array(
            'id' => (string)$news -> _id,
            'errors' => count($errors) ? $errors: FALSE
        ));
    }

}