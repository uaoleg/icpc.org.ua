<?php

namespace common\components;

class Cli extends \yii\base\Component
{

    /**
     * Run console application command
     *
     * @param string $command
     * @param string $action
     * @param array  $options
     * @param array  $anonimParams
     * @param bool   $runInBackground
     * @return array
     */
    public function runCommand($command, $action = '', array $options = array(), array $anonimParams = array(), $runInBackground = false)
    {
        $cmd = '';

        // Set environment variable
        if (!$this->isWindows()) {
            $cmd .= 'APP_ENV=' . APP_ENV . ' ';
        }

        // Create command
        $path = \yii::getPathOfAlias('console') . DIRECTORY_SEPARATOR . 'yiic.php';
        $cmd .= 'php ' . $path . ' ' . $command;

        // Add action
        if ($action) {
            $cmd .= ' ' . $action;
        }

        // Add options
        if (count($options) > 0) {
            foreach ($options as $option => $valueList) {
                if ($valueList === null) continue;
                if (!is_array($valueList))
                    $valueList = array($valueList);
                foreach ($valueList as $value) {
                    if (is_int($option))
                        $cmd .= ' --' . $value;
                    elseif (is_string($option))
                        $cmd .= ' --' . $option . '="' . $value . '"';
                }
            }
        }

        // Add anonim params
        if (count($anonimParams) > 0) {
            foreach ($anonimParams as $param) {
                $cmd .= ' ' . $param;
            }
        }

        // If need to run in background
        if ($runInBackground) {
//            $cmd .= ' >> ' . \yii::getPathOfAlias('common.runtime.cli') . '/output.log 2>&1 & echo $!';
            if ($this->isWindows()) {
                $cmd .= ' > NUL';
            }
            else
                $cmd .= ' > /dev/null & echo $!';
        }

        // Execute command
        $lastLine = exec($cmd, $output, $return_var);

        // Return response
        $response = array(
            'last_line'  => $lastLine,
            'output'     => $output,
            'return_var' => $return_var,
        );
        return $response;
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
    public function isWindows()
    {
        $os = getenv('OS');
        $isWindows = (stripos($os, 'windows') !== false);
        return $isWindows;
    }

}