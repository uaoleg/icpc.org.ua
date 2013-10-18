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

// PHP settings
date_default_timezone_set('Europe/Kiev');
ini_set('display_errors', YII_DEBUG);
ini_set('display_startup_errors', YII_DEBUG);
ini_set('session.gc_maxlifetime', SECONDS_IN_WEEK);

// Path alias
\yii::setPathOfAlias('root', realpath(__DIR__ . '/../..'));
\yii::setPathOfAlias('common', \yii::getPathOfAlias('root.common'));
\yii::setPathOfAlias('console', \yii::getPathOfAlias('root.console'));
\yii::setPathOfAlias('web', \yii::getPathOfAlias('root.web'));

$main = array(

    'charset'   => 'UTF-8',
    'id'        => 'icpcapp',
    'name'      => 'ICPC',

    'components' => array(

        'array' => array(
            'class' => '\common\components\ArrayHelper',
        ),

        'authManager' => array(
            'class'         => '\common\ext\MongoDb\Auth\Manager',
            'defaultRoles'  => array('guest'),
            'showErrors'    => YII_DEBUG,
        ),

        'cache' => array(
            'class'         => 'common.lib.yii.caching.CMemCache',
            'useMemcached'  => false,
        ),

        'cli' => array(
            'class' => '\common\components\Cli',
        ),

        'errorHandler' => array(
            'class'         => '\common\components\ErrorHandler',
            'errorAction'   => 'index/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
            ),
        ),

        'mail' => array(
            'class'            => '\common\ext\Mail\Mail',
            'transportType'    => 'smtp',
            'layoutPath'       => \yii::getPathOfAlias('web.views.layouts'),
            'viewPath'         => 'web.views.mail',
            'dryRun'           => false,
            'transportOptions' => array(
                'host'     => 'smtp.mandrillapp.com',
                'port'     => 587,
                'username' => 'ua.oleg@gmail.com',
                'password' => 'mkanRspYdB4JlOs_EQmoeQ',
            ),
        ),

        'messages' => array(
            'class'             => '\common\ext\Message\Source',
            'forceTranslation'  => true,
        ),

        'mongodb' => array(
            'class'             => '\common\ext\MongoDb\DB',
            'connectionString'  => 'mongodb://localhost/icpc',
            'dbName'            => 'icpc',
            'fsyncFlag'         => false,
            'safeFlag'          => false,
            'useCursor'         => true,
        ),

        'rbac' => array(
            'class' => '\common\components\Rbac',
        ),

        'request' => array(
            'class' => '\web\ext\HttpRequest',
        ),

        'session' => array(
            'class'     => 'CHttpSession',
            'savePath'  => \yii::getPathOfAlias('common.runtime.session'),
        ),

        'sprite' => array(
            'class'             => 'common.lib.YiiBootstrapCssSprite',
            'imgSourcePath'     => \yii::getPathOfAlias('web.www.themes.default.images'),
            'imgSourceExt'      => 'jpg,jpeg,gif,png',
            'imgSourceSkipSize' => 64,
            'imgDestPath'       => \yii::getPathOfAlias('web.www.themes.default.images') . '/sprite.png',
            'cssPath'           => \yii::getPathOfAlias('web.www.themes.default.css') . '/sprite.css',
            'cssImgUrl'         => '/themes/default/images/sprite.png',
        ),

        'themeManager' => array(
            'class'     => 'CThemeManager',
            'baseUrl'   => '/themes',
        ),

        'urlManager' => array(
            'caseSensitive'     => false,
            'showScriptName'    => false,
            'urlFormat'         => 'path',
            'rules'             => require(__DIR__ . '/urlManagerRules.php'),
        ),

    ),

    'import' => array(
        'common.lib.YiiMongoDbSuite.*',
    ),

    // Application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(__DIR__ . '/params.php'),

);

// Environment configuration
$file = __DIR__ . '/env/' . APP_ENV . '/main.php';
if (is_file($file)) {
    $main = \CMap::mergeArray($main, require($file));
}

// Local configuration
$file = dirname(__FILE__).'/local/main.php';
if (is_file($file)) {
    $main = \CMap::mergeArray($main, require($file));
}

return $main;