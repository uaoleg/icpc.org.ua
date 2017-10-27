<?php

namespace frontend\controllers;

use \common\models\User;
use \yii\helpers\Url;

/**
 * Base controller
 */
class BaseController extends \common\controllers\BaseController
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Generate sprite
        if (\YII_ENV === \YII_ENV_DEV) {
            \yii::$app->sprite->generate();
        }

        // Restore nav active items
        $this->_navActiveItems = \yii::$app->user->getState('nav-active-items', array());

        // Set default RBAC role
        \yii::$app->authManager->defaultRoles = \yii::$app->user->isGuest
            ? [User::ROLE_GUEST]
            : [User::ROLE_USER]
        ;

        // Set application language and save it with the help of cookies
        if (!\yii::$app->user->isGuest) {
            $settings = \yii::$app->user->identity->settings;
            if (isset($settings->lang)) {
                \yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'language',
                    'value' => $settings->lang,
                ]));
            } else {
                $settings->lang = \yii::$app->request->getValue('language');
                $settings->save();
            }

        }
        if (!\yii::$app->request->cookies->has('language')) {
            $languageCodes = array_keys(\yii::$app->params['languages']);
            $langCode = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $defaultLang = (in_array($langCode, $languageCodes)) ? $langCode : 'uk';
            \yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'language',
                'value' => $defaultLang,
            ]));
        }
        if (\yii::$app->request->cookies->has('language')) {
            \yii::$app->language = \yii::$app->request->cookies->getValue('language');
        }

        // Set core language
        switch (\yii::$app->language) {
            case 'en':
            case 'uk':
                \yii::$app->user->languageCore = \yii::$app->language;
                break;
            default:
                \yii::$app->user->languageCore = 'uk';
                break;
        }

        //  Include language file for Select2
        switch (\yii::$app->language) {
            case 'uk':
                $this->view->registerJsFile('@web/lib/select2/select2_locale_ua.js');
                break;
            case 'ru':
                $this->view->registerJsFile('@web/lib/select2/select2_locale_ru.js');
                break;
        }

        // Set default page title
        if (empty($this->view->title)) {
            $name = ucfirst(basename($this->id));
            if ($this->action && strcasecmp($this->action->id, $this->defaultAction)) {
                $this->view->title = ucfirst($this->action->id) . ' ' . $name . ' - ' . \yii::$app->name;
            } else {
                $this->view->title = $name . ' - ' . \yii::$app->name;
            }
        }


        // Render modals and widget scripts
        $this->view->on(\yii\web\View::EVENT_END_BODY, function() {
            echo $this->view->blocks['modals'] ?? '';
            echo $this->view->blocks['scripts'] ?? '';
        });
    }

    /**
     * Remembers referrer for particular model
     * @param int $modelId
     * @param string $forceUrl
     */
    protected function referrerActionRemember($modelId, $forceUrl = null)
    {
        // Handle form submit and page reload
        if ($forceUrl === null) {
            $currentActionUrl = Url::toRoute(["/{$this->id}/{$this->action->id}"], true);
            if (mb_strpos(\yii::$app->request->referrer, $currentActionUrl) !== false) {
                return;
            }
            $referrer = \yii::$app->request->referrer;
        } else {
            $referrer = $forceUrl;
        }

        // Remember referrer for particular model
        \yii::$app->session->set($this->referrerActionSessionKey($modelId), $referrer);
    }

    /**
     * Returns referrer for particular model
     * @param int $modelId
     * @param string $defaultUrl
     * @return string
     */
    protected function referrerActionPrevious($modelId, $defaultUrl)
    {
        return \yii::$app->session->get($this->referrerActionSessionKey($modelId), $defaultUrl);
    }

    /**
     * Returns session key for of referrer for particular model
     * @param int $modelId
     * @return string
     */
    protected function referrerActionSessionKey($modelId)
    {
        return "referrerAction.{$this->id}.{$modelId}";
    }

    /**
     * Throws an exception caused by invalid operations of end-users
     * @param int    $status HTTP status code, such as 404, 500, etc.
	 * @param string $message error message
	 * @param int    $code error code
     * @throws \yii\web\HttpException
     */
    public function httpException($status, $message = null, $code = 0)
    {
        throw new \yii\web\HttpException($status, $message, $code);
    }

}
