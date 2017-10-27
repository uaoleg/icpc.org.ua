<?php

namespace frontend\controllers;

class IndexController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
                'view'  => '@frontend/views/index/error',
            ],
        ];
    }

    /**
     * Main page
     */
    public function actionIndex()
    {
        return $this->redirect(['/news/latest']);
    }

}