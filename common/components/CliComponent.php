<?php

namespace common\components;

class CliComponent extends BaseComponent
{

    /**
     * Run console application command
     *
     * @param string $command
     * @param string $action
     * @param array  $options
     * @param array  $anonimParams
     * @param bool   $runInBackground
     */
    public function runCommand($command, $action = '', array $options = [], array $anonimParams = [], $runInBackground = false)
    {
return;
        $cmd = '';

        // Set environment variable
        if (!$this->isWindows()) {
            $cmd .= 'YII_ENV=' . YII_ENV . ' ';
        }

        // Create command
        $path = \yii::getAlias('@root') . DIRECTORY_SEPARATOR . 'yii';
        $cmd .= 'php ' . $path . ' ' . $command;

        // Add action
        if ($action) {
            $cmd .= '/' . $action;
        }

        // Add options
        setlocale(LC_CTYPE, 'en_US.UTF-8'); /** @link http://php.net/manual/en/function.escapeshellarg.php#99213 */
        if (count($options) > 0) {
            foreach ($options as $option => $valueList) {
                if ($valueList === null) {
                    continue;
                }
                if (!is_array($valueList)) {
                    $valueList = [$valueList];
                }
                foreach ($valueList as $value) {
                    if (is_int($option)) {
                        $cmd .= ' ' . $value;
                    } elseif (is_string($option)) {
                        $cmd .= ' ' . escapeshellarg($value);
                    }
                }
            }
        }

        // Add anonim params
        if (count($anonimParams) > 0) {
            foreach ($anonimParams as $param) {
                $cmd .= ' ' . $param;
            }
        }

        // Execute command and write logs
        if ($runInBackground) {
            $logFile = \yii::getAlias("@app/runtime/logs/cli-{$command}-{$action}.log");
            $pidFile = \yii::getAlias("@app/runtime/logs/cli-{$command}-{$action}.pid.log");
            exec(sprintf("%s >> %s 2>&1 & echo $! >> %s", $cmd, $logFile, $pidFile));
        } else {
            exec($cmd);
        }
    }

    /**
     * Run command under given user
     *
     * @param string$user
     * @param string $cmd
     * @return string
     */
    public function useUser($user, $cmd)
    {
        if ($user)
            return "sudo su -l $user -p -c \"$cmd\"";
        else
            return $cmd;
    }

    /**
     * Check if env OS is Windows
     *
     * @return bool
     */
    protected function isWindows()
    {
        $os = getenv('OS');
        $isWindows = (stripos($os, 'windows') !== false);
        return $isWindows;
    }

}