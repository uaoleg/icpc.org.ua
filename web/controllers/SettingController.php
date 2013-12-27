<?php

namespace web\controllers;

class SettingController extends \web\ext\Controller
{

    /**
     * Set language
     */
    public function actionLang()
    {
        // Get params
        $langCode = $this->request->getParam('code');

        // Store language code into cookies if it's defined
        $languageCodes = array_keys(\yii::app()->params['languages']);
        if (in_array($langCode, $languageCodes)) {
            \yii::app()->request->cookies['language'] = new \CHttpCookie('language', $langCode);
            if (!\yii::app()->user->isGuest) {
                $settings = \yii::app()->user->getInstance()->settings;
                $settings->lang = $langCode;
                $settings->save();
            }
        }

        // Return to previous page
        $this->redirect($this->request->getUrlReferrer());
    }

}