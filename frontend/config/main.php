<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return \yii\helpers\ArrayHelper::merge(require(__DIR__ . '/../../common/config/main-web.php'), [
    'id' => \APP_FRONTEND,
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'index/index',
    'components' => [
        'menu' => \frontend\components\MenuComponent::class,
        'request' => [
            'class' => \frontend\components\Request::class,
        ],
        'view' => \frontend\components\View::class,
    ],
    'modules' => [
        'staff' => [
            'class' => \frontend\modules\staff\StaffModule::class,
        ],
        'test' => [
            'class' => \frontend\modules\test\TestModule::class,
        ],
    ],
    'params' => $params,
]);
