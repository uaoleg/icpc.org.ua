<?php

namespace web\modules\staff\controllers;

use \common\ext\Message;

class LangController extends \web\modules\staff\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set active main menu item
        $this->setNavActiveItem('main', 'lang');
    }

    /**
     * Main page
     */
    public function actionIndex()
    {
        // Render view
        $this->render('index', $this->data);
    }

    /**
     * Get list of messages for jqGrid
     */
    public function actionGetMessageList()
    {
        // Get jqGrid params
        $jqgrid = $this->_getJqgridParams(Message\Item::model());

        // Fill rows
        $rows = array();
        foreach ($jqgrid['itemList'] as $message) {
            $rows[] = array(
                'id'   => (string)$message->_id,
                'cell' => array(
                    $message->language,
                    $message->message,
                    $message->translation,
                ),
            );
        }

        // Render json
        $this->data = array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
        );
        $this->renderJson($this->data);
    }

    /**
     * Save single translation
     */
    public function actionSaveTranslation()
    {
        // Get params
        $id             = $this->request->getParam('id');
        $operation      = $this->request->getParam('oper');
        $translation    = $this->request->getParam('translation');

        switch ($operation) {
            case 'edit':
                $message = Message\Item::model()->findByPk(new \MongoId($id));
                $message->translation = $translation;
                $message->save();
                break;
        }
    }

    /**
     * Parse translations in file
     */
    public function actionParse()
    {
        \yii::app()->cli->runCommand('message', 'parse', array(), array(), false);
    }

    /**
     * Generate translation messages for js files
     */
    public function actionGenerateJs()
    {
        \yii::app()->cli->runCommand('message', 'generateJs', array(), array(), false);
    }

    /**
     * Dictionaries manage
     */
    public function actionDictionaries()
    {
        // Set active language submenu item
        $this->setNavActiveItem('lang', 'dictionaries');

        // Render view
        $this->render('dictionaries', $this->data);
    }

    /**
     * Get list of dictionaries for jqGrid
     */
    public function actionGetDictionaryList()
    {
        // Get jqGrid params
        $jqgrid = $this->_getJqgridParams(Dictionary::model());

        // Fill rows
        $rows = array();
        foreach ($jqgrid['itemList'] as $dictionary) {
            $rows[] = array(
                'id'   => (string)$dictionary->_id,
                'cell' => array(
                    $dictionary->name,
                    $this->renderPartial('dictionaries/cellMessageList', array('dictionary' => $dictionary), true),
                    $this->renderPartial('dictionaries/cellActions', array(), true),
                ),
            );
        }

        // Render json
        $this->data = array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
        );
        $this->renderJson($this->data);
    }

    /**
     * Save dictionary
     */
    public function actionSaveDictionary()
    {
        // Get params
        $id             = $this->getParam('id');
        $messageList    = $this->getParam('messageList');

        // Convert string to array
        if (is_string($messageList)) {
            $messageList = explode("\n", $messageList);
        }

        // Save dictionary
        $dictionary = Dictionary::model()->findByPk(new \MongoId($id));
        $dictionary->messageList = $messageList;
        $dictionary->save();
    }

}