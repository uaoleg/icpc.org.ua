<?php

namespace web\controllers;

class PageController extends \web\ext\Controller
{

    /**
     * Agreement
     */
    public function actionAgreement()
    {
        // Render view
        $this->render('agreement');
    }

}