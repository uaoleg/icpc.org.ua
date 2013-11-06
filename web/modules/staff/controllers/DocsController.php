<?php

namespace web\modules\staff\controllers;

use \common\models\Document;

class DocsController extends \web\modules\staff\ext\Controller
{

    /**
     * Returns the access rules for this controller
     *
     * @return array
     */
    public function accessRules()
    {
        return array(
            array(
                'allow',
                'actions'   => array('create'),
                'roles'     => array('documentCreate'),
            ),
            array(
                'allow',
                'actions'   => array('edit', 'publish'),
                'roles'     => array('documentUpdate'),
            ),
            array(
                'allow',
                'actions'   => array('delete'),
                'roles'     => array('documentDelete'),
            ),
            array(
                'deny',
            ),
        );
    }

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
        $id     = $this->request->getParam('id');
        $type   = $this->request->getParam('type');
        $title  = $this->request->getPost('title');
        $desc   = $this->request->getPost('desc');

        // Create document
        $document = Document::model()->findByPk(new \MongoId($id));
        if ($document === null) {
            if (empty($id)) {
                $document = new Document();
            } else {
                return $this->httpException(404);
            }
        }

        // Set document type
        if (!empty($type)) {
            $document->type = $type;
        }

        // Save document
        if ($this->request->isPostRequest) {
            $isNew = $document->getIsNewRecord();
            $document->setAttributes(array(
                'title' => $title,
                'desc'  => $desc,
                'type'  => $type,
            ), false);
            $document->save();
            $errors = $document->getErrors();
            $this->renderJson(array(
                'id'        => (string)$document->_id,
                'isNew'     => $isNew,
                'errors'    => count($errors) > 0 ? $errors : false,
            ));
        }

        // Render view
        else {
            $this->render('edit', array(
                'document' => $document,
            ));
        }
    }

    /**
     * Publish or hide document
     */
    public function actionPublish()
    {
        // Get params
        $id     = $this->request->getParam('id');
        $status = (bool)$this->request->getParam('status');

        // Get document
        $document = Document::model()->findByPk(new \MongoId($id));
        $document->isPublished = $status;
        $document->save();

        // Redirect to edit page
        $this->redirect(array('edit', 'id' => $document->_id));
    }

    /**
     * Delete document
     */
    public function actionDelete()
    {
        // Get params
        $id = $this->request->getParam('id');

        // Get document
        $document = Document::model()->findByPk(new \MongoId($id));
        if ($document === null) {
            return;
        }

        // Delete document
//        $document->delete();
    }

}