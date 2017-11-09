<?php

namespace frontend\controllers;

use \common\models\Document;
use \yii\helpers\Url;

class DocsController extends BaseController
{

    /**
     * Returns list of documents
     *
     * @param string $type
     * @return \EMongoCursor
     */
    protected function _getDocumentList($type = null)
    {
        return Document::find()
            ->andFilterWhere(['type' => $type])
            ->orderBy('timeCreated DESC')
            ->all()
        ;
    }

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'regulations';

        // Set active main menu item
        $this->setNavActiveItem('main', 'docs');
    }

    /**
     * Regulations docs
     */
    public function actionRegulations()
    {
        // Get list of documents
        $documentList = $this->_getDocumentList(Document::TYPE_REGULATIONS);

        // Render view
        return $this->render('regulations', array(
            'documentList' => $documentList,
        ));
    }

    /**
     * Guidance docs
     */
    public function actionGuidance()
    {
        // Get list of documents
        $documentList = $this->_getDocumentList(Document::TYPE_GUIDANCE);

        // Render view
        return $this->render('guidance', array(
            'documentList' => $documentList,
        ));
    }

    /**
     * Download document
     */
    public function actionDownload()
    {
        // Get params
        $id = (int)\yii::$app->request->get('id');

        // Get document
        $document = Document::findOne($id);
        if ($document === null) {
            return $this->httpException(404);
        }

        // Nice filename
        $filename = $document->title;
        $lastOccur = mb_strrpos($filename, $document->fileExt);
        if (($lastOccur === false) || ($lastOccur < mb_strlen($filename) - mb_strlen($document->fileExt) - 1)) {
            $filename .= '.' . $document->fileExt;
        }
        if (\yii::$app->request->userAgentIsMsie()) {
            $filename = urlencode($filename);
        }

        // Download file
        return \yii::$app->response->sendContentAsFile($document->content, $filename);
    }

    /**
     * View info about document
     */
    public function actionView()
    {
        // Get params
        $documentId = (int)\yii::$app->request->get('id');

        // Get document
        $document = Document::findOne($documentId);
        if ($document === null) {
            $this->httpException(404);
        }

        // Define redirect URL
        switch ($document->type) {
            case Document::TYPE_GUIDANCE:
                $afterDeleteRedirect = Url::toRoute(['/docs/guidance']);
                break;
            case Document::TYPE_REGULATIONS:
                $afterDeleteRedirect = Url::toRoute(['/docs/regulations']);
                break;
            default:
                $afterDeleteRedirect = Url::toRoute(['/docs']);
                break;
        }

        // Render view
        return $this->render('view', array(
            'document'              => $document,
            'afterDeleteRedirect'   => $afterDeleteRedirect,
        ));
    }

}