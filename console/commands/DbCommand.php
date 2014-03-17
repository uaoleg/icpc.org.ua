<?php

class DbCommand extends \console\ext\ConsoleCommand
{

    /**
     * Create DB backup
     *
     * @param string $name backup file name
     */
    public function actionDump($name, $host = 'localhost')
    {
        // Create backup
        echo "Dumping DB...\n";
        $dumpFolder = uniqid('mongodump-' . $name);
        $dumpPath = \yii::getPathOfAlias('console.runtime') . DIRECTORY_SEPARATOR . $dumpFolder;
        if (!is_dir($dumpPath)) {
            mkdir($dumpPath);
        }
        $dbName = \yii::app()->mongodb->dbName;
        chmod(__DIR__ . '/../mongodump', 0100);
        $commandDump = __DIR__ . "/../mongodump --host={$host} --db={$dbName} --out={$dumpPath}";
        exec($commandDump);

        // Archive
        echo "Archiving...\n";
        $zipPath = \yii::getPathOfAlias('root.dumps') . DIRECTORY_SEPARATOR . "{$name}.zip";
        \yii::app()->archive->compress($dumpPath, $zipPath);

        // Delete the dump
        echo "Deleting DB dump...\n";
        $it = new \RecursiveDirectoryIterator($dumpPath);
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if (($file->getFilename() === '.') || ($file->getFilename() === '..')) {
                continue;
            } elseif ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dumpPath);

        // Done
        echo "Done\n";
    }

}