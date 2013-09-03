<?php

// Set deafault time zone
date_default_timezone_set('UTC');

return array(

    'basePath'  => __DIR__ . DIRECTORY_SEPARATOR . '..',

    'behaviors'=>array(
        'templater' => '\console\ext\ConsoleTemplater',
    ),

    'components' => array(

        'urlManager' => array(
            'baseUrl' => '',
        ),

        'widgetFactory' => array(
            'class' => '\web\ext\WidgetFactory',
        ),

    ),

    // Application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__).'/params.php'),

);