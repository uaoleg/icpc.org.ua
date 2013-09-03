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
        $this->forward('edit');
    }

    /**
     * Edit page
     */
    public function actionEdit()
    {
        // Get params
        $id         = $this->request->getParam('id');
        $title      = $this->request->getPost('title');
        $content    = $this->request->getPost('content');

        // Create news
        $news = News::model()->findByPk(new \MongoId($id));
        if ($news === null) {
            if (empty($id)) {
                $news = new News();
            } else {
                return $this->httpException(404);
            }
        }

        // Save news
        if ($this->request->isPostRequest) {
            $isNew = $news->getIsNewRecord();
            $news->setAttributes(array(
                'title'     => $title,
                'content'   => $content,
            ), false);
            $news->save();
            $errors = $news->getErrors();
            $this->renderJson(array(
                'id'        => (string)$news->_id,
                'isNew'     => $isNew,
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

        // Redirect to edit page
        $this->redirect(array('edit', 'id' => $news->_id));
    }

}