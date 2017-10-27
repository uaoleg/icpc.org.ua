<?php

// Define constants
defined('BYTES_IN_KB') or define('BYTES_IN_KB', 1024);
defined('BYTES_IN_MB') or define('BYTES_IN_MB', 1048576);
defined('BYTES_IN_GB') or define('BYTES_IN_GB', 1073741824);
defined('SECONDS_IN_MINUTE') or define('SECONDS_IN_MINUTE', 60);
defined('SECONDS_IN_HOUR') or define('SECONDS_IN_HOUR', 3600);
defined('SECONDS_IN_DAY') or define('SECONDS_IN_DAY', 86400);
defined('SECONDS_IN_WEEK') or define('SECONDS_IN_WEEK', 604800); // 7 days
defined('SECONDS_IN_MONTH') or define('SECONDS_IN_MONTH', 2678400); // 31 day
defined('SECONDS_IN_YEAR') or define('SECONDS_IN_YEAR', 31449600); // 364 days
defined('SESSION_TIME') or define('SESSION_TIME', SECONDS_IN_WEEK);
defined('DATE_FORMAT_DB') or define('DATE_FORMAT_DB', 'yyyy-MM-dd');
defined('DATE_TIME_FORMAT_DB') or define('DATE_TIME_FORMAT_DB', 'yyyy-MM-dd HH:mm:ss');
defined('DATE_FORMAT_MYSQL_QUERY') or define('DATE_FORMAT_MYSQL_QUERY', '%d.%m.%Y');
defined('DATE_FORMAT_JS') or define('DATE_FORMAT_JS', 'DD.MM.YYYY');
defined('DATE_TIME_FORMAT_JS') or define('DATE_TIME_FORMAT_JS', 'DD.MM.YYYY HH:mm:ss');
defined('APP_FRONTEND') or define('APP_FRONTEND', 'app-frontend');

return [
    'id' => 'icpcapp',
    'name' => 'ICPC',
    'bootstrap' => ['log'],
    'language'          => 'ru-RU',
    'sourceLanguage'    => 'ru-RU',
    'sourceLanguage'    => 'uk_RU', /* Fix @url https://github.com/yiisoft/yii2/issues/7430 */
    'timezone'          => 'Europe/Kiev',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'archive' => [
            'class' => \common\components\Archive::class,
        ],
        'array' => [
            'class' => \common\components\ArrayHelper::class,
        ],
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],
        'baylor' => [
            'class' => \common\components\Baylor::class,
        ],
        'cache' => [
            'class' => \yii\caching\MemCache::class,
        ],
        'cli' => [
            'class' => \common\components\CliComponent::class,
        ],
        'db' => [
            'class'     => \yii\db\Connection::class,
            'dsn'       => 'mysql:host=localhost;dbname=icpc',
            'charset'   => 'utf8',
        ],
        'email' => [
            'class'     => \common\components\Mailgun\Mailer::class,
            'domain'    => 'icpc.org.ua',
            'username'  => 'postmaster@icpc.org.ua',
            'password'  => '6806dec621801ef6d20c23af87d255ce',
            'viewPath'  => '@common/emails',
        ],
        'formatter' => [
            'class'             => \common\components\Formatter::class,
            'dateFormat'        => 'dd.MM.yyyy',
            'datetimeFormat'    => 'dd.MM.yyyy HH:mm',
            'decimalSeparator'  => '.',
            'nullDisplay'       => '<span class="not-set">' . \yii::t('app', '(нет данных)') . '</span>',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => \common\components\Message\Source::class,
                    'forceTranslation'  => true,
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class'     => \common\components\LogSentryTarget::class,
                    'dsn'       => 'https://a1c6fda54bbf4a9e867fe632e239c85a:31480f6161b947d6a4c3cc5013def978@sentry.io/231872',
                    'levels'    => ['error', 'warning'],
                    'except'    => [
                        \yii\web\ForbiddenHttpException::class,
                        \yii\web\HttpException::class . ':404',
                    ],
                    'context'   => true,
                    'enabled'   => YII_ENV_PROD,
                    'dailyLimit'=> 300,
                ],
                [
                    'class'     => \yii\log\FileTarget::class,
                    'logFile'   => '@runtime/logs/app.log',
                ],
            ],
        ],
        'rbac' => [
            'class' => \common\components\Rbac::class,
        ],
        'sprite' => [
            'class'             => \common\components\YiiBootstrapCssSprite::class,
//            'imgSourcePath'     => \yii::getAlias('@web/images'),
//            'imgSourceExt'      => 'jpg,jpeg,gif,png',
//            'imgSourceSkipSize' => 64,
//            'imgDestPath'       => \yii::getAlias('@web/images/sprite.png'),
//            'cssPath'           => \yii::getAlias('@web/css/sprite.css'),
//            'cssImgUrl'         => Url::to('/images/sprite.png'),
        ],
        'urlManager' => [
            'class'             => \yii\web\UrlManager::class,
            'enablePrettyUrl'   => true,
            'showScriptName'    => false,
        ],
    ],
];
