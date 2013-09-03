<?php

namespace web\controllers;

class IndexController extends \web\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Main page
     */
    public function actionIndex()
    {
        $this->forward('/news/latest');
    }

    /**
     * Error page
     */
    public function actionError()
    {
        // Get error
        $error = \yii::app()->errorHandler->error;
        if (empty($error['message'])) {
            switch ($error['code']) {
                case 403:
                    $error['message']= \yii::t('app', 'Access forbidden');
                    break;
                case 404:
                    $error['message'] = \yii::t('app', 'Requested page not found');
                    break;
                default:
                    $error['message'] = \yii::t('app', 'Unknown error');
                    break;
            }
        }

        // Render view
        $this->render('error', array(
            'error' => $error,
        ));
    }

}