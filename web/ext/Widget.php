<?php

namespace web\ext;

class Widget extends \CWidget
{

    /**
     * Static method to render widget (without specifying of class name)
     *
     * @param array $properties
     * @param type $captureOutput
     * @return mixed the widget instance when $captureOutput is false, or the widget output when $captureOutput is true
     */
    public static function create(array $properties = array(), $captureOutput = false)
    {
        return \yii::app()->controller->widget(get_called_class(), $properties, $captureOutput);
    }

    /**
     * Create URL
     *
     * @param string $route
     * @param array  $params
     * @param string $ampersand
     * @return string
     */
    public function createUrl($route, array $params = array(), $ampersand = '&')
    {
        return \yii::app()->createUrl($route, $params, $ampersand);
    }

    /**
     * Safe encode array to json string
     *
     * @param mixed $data
     * @return string
     */
    public function jsonEncode($data)
    {
        return \yii::app()->controller->jsonEncode($data);
    }

}