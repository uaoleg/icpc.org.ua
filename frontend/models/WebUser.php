<?php

namespace frontend\models;

/**
 * Web user component
 *
 * @property \common\models\User $identity
 *
 * @property-read array $homeUrl
 */
class WebUser extends \yii\web\User
{

    const SESSION_INFO_NOT_FULL = 'user.sessionInfoNotFull';

    /**
     * Core language - "en" or "uk, but not "ru", etc.
     * @var string
     */
    public $languageCore;

    /**
     * Returns user's home URL
     * @return array
     */
    public function getHomeUrl()
    {
        return [\yii::$app->homeUrl];
    }

    /**
     * Save session state
     * @param string $key
     * @param mixed $value
     */
    public function setState($key, $value)
    {
        \yii::$app->session->set(static::class . '\\' . $key, $value);
    }

    /**
     * Returns session state
     * @param string $key
     * @param mixed $defaultValue
     * @param bool $clearValue
     * @return mixed
     */
    public function getState($key, $defaultValue = null, $clearValue = false)
    {
        $key = static::class . '\\' . $key;
        $value = \yii::$app->session->get($key, $defaultValue);
        if ($clearValue) {
            \yii::$app->session->set($key, $defaultValue);
        }
        return $value;
    }

}
