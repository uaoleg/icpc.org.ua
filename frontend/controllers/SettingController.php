<?php

namespace frontend\controllers;

class SettingController extends BaseController
{

    /**
     * Set language
     */
    public function actionLang()
    {
        // Get params
        $langCode = \yii::$app->request->get('code');

        // Store language code into cookies if it's defined
        $languageCodes = array_keys(\yii::$app->params['languages']);
        if (in_array($langCode, $languageCodes)) {
            \yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'language',
                'value' => $langCode,
            ]));
            if (!\yii::$app->user->isGuest) {
                $settings = \yii::$app->user->identity->settings;
                $settings->lang = $langCode;
                $settings->save();
            }
        }

        // Return to previous page
        $this->redirect(\yii::$app->request->referrer);
    }

}