<?php

namespace web\ext;

class Widget extends \CWidget
{

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