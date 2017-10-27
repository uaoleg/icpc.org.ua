<?php

namespace frontend\modules\staff\controllers;

use \common\components\Message;
use \frontend\modules\staff\search\LangSearch;

class LangController extends \frontend\modules\staff\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set active main menu item
        $this->setNavActiveItem('main', 'admin');
    }

    /**
     * Main page
     */
    public function actionIndex()
    {
        // Get list of students
        $search = new LangSearch;
        $provider = $search->search(\yii::$app->request->queryParams);

        // Render view
        return $this->render('index', array(
            'provider'  => $provider,
            'search'    => $search,
        ));
    }

    /**
     * Save single translation
     */
    public function actionSaveTranslation()
    {
        // Get params
        $id             = \yii::$app->request->get('id');
        $operation      = \yii::$app->request->get('oper');
        $translation    = \yii::$app->request->get('translation');

        switch ($operation) {
            case 'edit':
                $message = Message\Item::findOne($id);
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
        \yii::$app->cli->runCommand('translation', 'parse', array(), array(), false);
        return $this->redirect(['index']);
    }

    /**
     * Generate translation messages for js files
     */
    public function actionGenerateJs()
    {
        \yii::$app->cli->runCommand('translation', 'generateJs', array(), array(), false);
        return $this->redirect(['index']);
    }

}