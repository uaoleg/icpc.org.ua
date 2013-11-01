<?php

namespace web\controllers;

class TeamController extends \web\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set default action
        $this->defaultAction = 'list';

        // Set active main menu item
        $this->setNavActiveItem('main', '');
    }

    public function actionList()
    {
        $this->render('list', array());
    }

    public function actionCreate()
    {
        $school = \yii::app()->user->getInstance()->getSchool();
        $this->render('create', array(
            'school' => $school
        ));
    }

    public function actionSaveSchoolInfo()
    {
        // Action is available only for post/ajax requests
        if ($this->request->isAjaxRequest && $this->request->isPostRequest) {

            $shortNameUk = $this->request->getPost('shortNameUk');
            $fullNameEn  = $this->request->getPost('fullNameEn');
            $shortNameEn = $this->request->getPost('shortNameEn');

            $school = \yii::app()->user->getInstance()->getSchool();

            $school->setAttributes(array(
                'shortNameUk' => $shortNameUk,
                'fullNameEn'  => $fullNameEn,
                'shortNameEn' => $shortNameEn,
            ));
            $school->save();

            $this->renderJson(array(
                'errors' => $school->hasErrors() ? $school->getErrors() : false
            ));
        } else {
            return $this->httpException(403);
        }
    }

}