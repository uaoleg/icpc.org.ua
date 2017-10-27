<?php

namespace frontend\controllers;

class PageController extends BaseController
{

    /**
     * Agreement
     */
    public function actionAgreement()
    {
        // Render view
        return $this->render('agreement');
    }

}