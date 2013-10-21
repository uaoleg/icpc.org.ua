<?php

/**
 * Define application environment
 * @filesource /vhosts.conf
 */
defined('APP_ENV_DEV') or define('APP_ENV_DEV', 'development');
defined('APP_ENV_ACC') or define('APP_ENV_ACC', 'acceptance');
defined('APP_ENV_PROD') or define('APP_ENV_PROD', 'production');
$appEnv = isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : APP_ENV_DEV;
defined('APP_ENV') or define('APP_ENV', $appEnv);
switch (APP_ENV) {
    case APP_ENV_DEV:
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        break;
    case APP_ENV_ACC:
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        break;
    case APP_ENV_PROD:
        defined('YII_DEBUG') or define('YII_DEBUG', false);
        break;
}

// Define Yii
require_once __DIR__ . '/../../common/lib/yii/YiiBase.php';
class Yii extends YiiBase {
    /**
     * @static
     * @return WebApplication
     */
    public static function app()
    {
        return parent::app();
    }
}
/**
 * @property-read \common\components\ArrayHelper    $array
 * @property-read \common\ext\MongoDb\Auth\Manager  $authManager
 * @property-read \common\components\Cli            $cli
 * @property-read \CClientScript                    $clientScript
 * @property-read \common\components\ErrorHandler   $errorHandler
 * @property-read \CLogRouter                       $log
 * @property-read \common\ext\MongoDb\DB            $mongodb
 * @property-read \YiiBootstrapCssSprite            $sprite
 * @property-read \common\components\Rbac           $rbac
 * @property-read \web\ext\HttpRequest              $request
 * @property-read \web\ext\WebUser                  $user
 */
abstract class WebApplication extends CApplication
{
    // This is fake class only for autocomplete
}

// Launch application
$app = \yii::createWebApplication(__DIR__ . '/../config/main.php');
$app->log;
$app->run();