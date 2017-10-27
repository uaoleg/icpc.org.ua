<?php

namespace frontend\modules\staff\controllers;

use \common\models\Document;

class DocsController extends \frontend\modules\staff\ext\Controller
{

    /**
     * Returns the access rules for this controller
     *
     * @return array
     */
    public function accessRules()
    {
        // Returns document by ID GET param
        $getDocument = function() {
            $id = \yii::$app->request->get('id');
            return Document::findOne($id);
        };

        // Return rules
        return array(
            array(
                'allow',
                'actions'   => array('create'),
                'roles'     => array(\common\components\Rbac::OP_DOCUMENT_CREATE),
            ),
            array(
                'allow',
                'actions'   => array('edit', 'publish'),
                'roles'     => array(\common\components\Rbac::OP_DOCUMENT_UPDATE => array(
                    'document' => $getDocument(),
                )),
            ),
            array(
                'allow',
                'actions'   => array('delete'),
                'roles'     => array(\common\components\Rbac::OP_DOCUMENT_DELETE => array(
                    'document' => $getDocument(),
                )),
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
        return $this->redirect(['edit']);
    }

    /**
     * Edit page
     */
    public function actionEdit()
    {
        // Get params
        $id     = \yii::$app->request->get('id');
        $type   = \yii::$app->request->get('type');
        $title  = \yii::$app->request->post('title');
        $desc   = \yii::$app->request->post('desc');

        // Create document
        $document = Document::findOne($id);
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
        if (\yii::$app->request->isPost) {
            $isNew = $document->isNewRecord;
            $document->setAttributes(array(
                'title' => $title,
                'desc'  => $desc,
                'type'  => $type,
            ), false);
            $document->save();
            $errors = $document->getErrors();
            return $this->renderJson(array(
                'id'        => $document->id,
                'isNew'     => $isNew,
                'errors'    => count($errors) > 0 ? $errors : false,
            ));
        }

        // Render view
        else {
            return $this->render('edit', array(
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
        $id     = \yii::$app->request->get('id');
        $status = (bool)\yii::$app->request->get('status');

        // Get document
        $document = Document::findOne($id);
        $document->isPublished = $status;
        $document->save();

        // Redirect to edit page
        $this->redirect(['edit', 'id' => $document->id]);
    }

    /**
     * Delete document
     */
    public function actionDelete()
    {
        // Get params
        $id = \yii::$app->request->get('id');

        // Get document
        $document = Document::findOne($id);
        if ($document === null) {
            return;
        }

        // Delete document
        $document->delete();
    }

}