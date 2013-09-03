<?php

namespace common\components;

class ErrorHandler extends \CErrorHandler
{

    /**
     * Render internal file
     *
     * @param string $viewFile
     * @param array  $data
     * @param bool   $return
     * @return string
     */
    public function renderInternal($viewFile, array $data = array(), $return = false)
    {
        // If \yii::app()->controller doesn't exist create a dummy controller to render the view
        if (isset(\yii::app()->controller)) {
            $controller = \yii::app()->controller;
        } else {
            $controller = new \CController('ErrorHandler');
        }

        // Render file
        return $controller->renderInternal($viewFile, $data, $return);
    }

}