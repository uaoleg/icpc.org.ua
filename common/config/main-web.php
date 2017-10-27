<?php

$localPath = __DIR__ . '/main-web-local.php';
$localConfig = file_exists($localPath) ? require($localPath) : [];

return yii\helpers\ArrayHelper::merge([
    'components' => [
        'assetManager' => [
            'class'     => \common\components\AssetManager::class,
            'bundles'   => false,
        ],
        'errorHandler' => [
            'errorAction' => 'index/error',
        ],
        'session' => [
            'class'     => \yii\web\Session::class,
            'name'      => 'icpc-web',
            'timeout'   => SECONDS_IN_WEEK,
            'cookieParams' => [
                'path'      => '/',
                'httpOnly'  => true,
                'domain'    => '.icpc.org.ua',
            ]
        ],
        'user' => [
            'class'             => \frontend\models\WebUser::class,
            'identityClass'     => \common\models\User::class,
            'enableAutoLogin'   => true,
            'identityCookie'    => [
                'name'      => 'icpc-web-identity',
                'httpOnly'  => true,
                'domain'    => '.icpc.org.ua',
            ],
        ],
    ],
], $localConfig);
