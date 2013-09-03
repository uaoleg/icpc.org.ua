<?php

/**
 * Define application environment
 * @filesource /etc/environment
 */
$appEnv = isset($_SERVER['APPLICATION_ENV']) ? $_SERVER['APPLICATION_ENV'] : 'development';
defined('APPLICATION_ENV') or define('APPLICATION_ENV', $appEnv);

$yii = __DIR__ . '/../common/lib/yii/yii.php';
require_once($yii);

$commonConfig = require_once(__DIR__ . '/../common/config/main.php');
$appConfig = require_once(__DIR__ . '/config/main.php');
$config = \CMap::mergeArray($commonConfig, $appConfig);

$yiic = __DIR__ . '/../common/lib/yii/yiic.php';
require_once($yiic);