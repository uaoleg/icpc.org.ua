<?php

namespace console\controllers;

class SystemController extends BaseController
{

	/**
	 * Install the project
	 */
	public function actionInstall()
	{
        // Check environment configuration
        if (!$this->actionCheckEnv()) {
            exit;
        }

        // Run internal actions
        $this->actionChmod();
        $this->actionInitDictionaries();

        // Define list of commands in right order
        $commandList = array(
            'message',
            'rbac init',
            'rbac initAdmin',
        );

        // Run each command
        foreach ($commandList as $command) {
            system('php yiic ' . $command);
            echo "\n===============================\n\n";
        }
	}

    /**
     * Change the mode of each FILE to MODE
     */
    public function actionChmod()
    {
        echo "Changing files mode...\n";
        chmod(\yii::getAlias('@common/runtime'), 0777);
        chmod(\yii::getAlias('@common/runtime/session'), 0777);
        chmod(\yii::getAlias('@console/runtime'), 0777);
        chmod(\yii::getAlias('@frontend/runtime'), 0777);
        echo "Done\n";
    }

    /**
     * Configure collections
     */
    public function actionConfigureCollections()
    {
        $mongoLogItem = \common\components\logging\MongoLogItem::model();
        echo $mongoLogItem->getCollectionName() . "\n";
        $mongoLogItem->configureCollection();

        echo "Done\n";
    }

    /**
     * Check environment configuration
     *
     * @return bool
     */
    public function actionCheckEnv()
    {
        $envError = false;

        // Dirs
        $dir = \yii::getAlias('@frontend/runtime');
        if (!is_writable($dir)) {
            $envError = true;
            echo "Error: $dir is not writable.";
        }

        // php.ini
        if (ini_get('mbstring.internal_encoding') != 'UTF-8') {
            $envError = true;
            echo "Error: set mbstring.internal_encoding = UTF-8";
        }

        // Extensions
        $extensionList = array('bz2', 'gd', 'intl', 'mbstring', 'memcache', 'oauth');
        foreach ($extensionList as $extension) {
            if (!extension_loaded($extension)) {
                $envError = true;
                echo "Error: Requires PHP $extension extension to be loaded.\n";
            }
        }

        // Error reporting
        if (ini_get('error_reporting') != E_ALL) {
            $envError = true;
            echo "Error: Set error_reporting to E_ALL.\n";
        }

        // Display resolution
        if ($envError) {
            echo "\nInstallation failed!\n";
            echo "Configure your environment properly to install the project.\n";
        }
        return !$envError;
    }

    /**
     * Flush cache
     */
    public function actionCacheFlush()
    {
        \yii::$app->cache->flush();
    }

}