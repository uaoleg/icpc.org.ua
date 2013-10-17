<?php

date_default_timezone_set('Europe/Kiev');

/**
 * Define application environment
 * @filesource /vhosts.conf
 */
$appEnv = isset($_SERVER['APPLICATION_ENV']) ? $_SERVER['APPLICATION_ENV'] : 'development';
defined('APPLICATION_ENV') or define('APPLICATION_ENV', $appEnv);
switch (APPLICATION_ENV) {
    case 'development':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        break;
    case 'acceptance':
        defined('YII_DEBUG') or define('YII_DEBUG', true);
        break;
    case 'production':
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
 * @property-read \common\components\ArrayHelper                $array
 * @property-read \common\ext\MongoDb\Auth\Manager              $authManager
 * @property-read \common\components\Cli                        $cli
 * @property-read \CClientScript                                $clientScript
 * @property-read \common\components\ErrorHandler               $errorHandler
 * @property-read \CLogRouter                                   $log
 * @property-read \common\ext\MongoDb\DB                        $mongodb
 * @property-read \YiiBootstrapCssSprite                        $sprite
 * @property-read \common\components\Rbac                       $rbac
 * @property-read \web\ext\WebUser                              $user
 */
abstract class WebApplication extends CApplication
{
    // This is fake class only for autocomplete
}

// Launch application
$app = \yii::createWebApplication(__DIR__ . '/../config/main.php');
$app->log;
$app->run();