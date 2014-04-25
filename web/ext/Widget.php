<?php

namespace web\ext;

class Widget extends \CWidget
{
    /**
     * Controller
     * @var \CController
     */
    protected static $_controller;

    /**
     * Returns controller for the widget
     * @return \CController
     */
    public static function controller()
    {
        if (static::$_controller === null) {
            if (\yii::app()->controller !== null) {
                static::$_controller = \yii::app()->controller;
            } else {
                static::$_controller = new \CController('Widget');
            }
        }
        return static::$_controller;
    }

    /**
     * Static method to render widget (without specifying of class name)
     *
     * @param array $properties
     * @param bool $captureOutput
     * @return mixed the widget instance when $captureOutput is false, or the widget output when $captureOutput is true
     */
    public static function create(array $properties = array(), $captureOutput = false)
    {
        return static::controller()->widget(get_called_class(), $properties, $captureOutput);
    }

    /**
     * Creates a widget and executes it
     *
     * @param array $properties
     * @return \CWidget
     */
    public static function begin(array $properties = array())
    {
        return static::controller()->beginWidget(get_called_class(), $properties);
    }

    /**
     * Ends the execution of the named widget
     *
     * @param string $id
     * @return \CWidget
     */
    public static function end($id = '')
    {
        return static::controller()->endWidget($id);
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
        return static::controller()->jsonEncode($data);
    }

}