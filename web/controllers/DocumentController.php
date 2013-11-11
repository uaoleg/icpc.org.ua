<?php

namespace web\controllers;

use \common\models\Document;

class DocumentController extends \web\ext\Controller
{

    /**
     * View info about document
     */
    public function actionView()
    {
        $documentId = $this->request->getParam('id');

        if (isset($documentId)) {

            $document = Document::model()->findByPk(new \MongoId($documentId));

            if ($document->file !== null) {
                $size = $document->file->getSize();
            } else {
                $size = 0;
            }
            if ($size < BYTES_IN_KB) {
                $sizeLabel = $size . ' b';
            } elseif ($size < BYTES_IN_MB) {
                $sizeLabel = number_format($size / BYTES_IN_KB, 2) . ' kb';
            } elseif ($size < BYTES_IN_GB) {
                $sizeLabel = number_format($size / BYTES_IN_MB, 2) . ' mb';
            } else {
                $sizeLabel = number_format($size / BYTES_IN_GB, 2) . ' gb';
            }

            $this->render('view', array(
                'document'  => $document,
                'sizeLabel' => $sizeLabel
            ));
        }
        return $this->httpException(404);
    }

}