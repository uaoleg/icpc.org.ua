<?php

namespace web\controllers;

use \common\models\Document;

class DocsController extends \web\ext\Controller
{

    /**
     * Returns list of documents
     *
     * @param string $type
     * @return \EMongoCursor
     */
    protected function _getDocumentList($type = null)
    {
        $criteria = new \EMongoCriteria();
        $criteria->sort('dateCreated', \EMongoCriteria::SORT_DESC);
        if ($type) {
            $criteria->addCond('type', '==', $type);
        }
        $documentList = Document::model()->findAll($criteria);
        return $documentList;
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
        $this->render('regulations', array(
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
        $this->render('guidance', array(
            'documentList' => $documentList,
        ));
    }

    /**
     * Download document
     */
    public function actionDownload()
    {
        // Get params
        $id = $this->request->getParam('id');

        // Get document
        $document = Document::model()->findByPk(new \MongoId($id));
        if ($document === null) {
            return $this->httpException(404);
        }

        // Nice filename
        $filename = $document->title;
        $lastOccur = mb_strrpos($filename, $document->fileExt);
        if (($lastOccur === false) || ($lastOccur < mb_strlen($filename) - mb_strlen($document->fileExt) - 1)) {
            $filename .= '.' . $document->fileExt;
        }
        if (\yii::app()->request->userAgentIsIe()) {
            $filename = urlencode($filename);
        }

        // Download file
        header('Content-type: application/' . $document->fileExt);
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo $document->file->getBytes();
    }

}