<?php

$commonConfig = require_once __DIR__ . '/../../common/config/main.php';

\yii::setPathOfAlias('web', \yii::getPathOfAlias('root.web'));

$config = array(

    'basePath'              => \yii::getPathOfAlias('root.web'),
    'controllerNamespace'   => 'web\controllers',
    'defaultController'     => 'index',
    'homeUrl'               => '/user/me',
    'layout'                => 'main',
    'layoutPath'            => \yii::getPathOfAlias('web.views.layouts'),
    'viewPath'              => \yii::getPathOfAlias('web.views.scripts'),
    'systemViewPath'        => \yii::getPathOfAlias('web.views.system'),
    'theme'                 => 'default',

    'components' => array(

        'clientScript' => array(
            'coreScriptUrl'             => '',
            'coreScriptPosition'        => CClientScript::POS_HEAD,
            'defaultScriptFilePosition' => CClientScript::POS_END,
            'packages' => array(
                'bootstrap' => array(
                    'js' => array(
                        'lib/bootstrap-3.0.0/js/bootstrap.min.js',
                        'lib/bootbox-4.1.0/bootbox.min.js',
                    ),
                    'css' => array(
                        'lib/bootstrap-3.0.0/css/bootstrap.min.css',
                    ),
                    'depends' => array('jquery'),
                ),
                'ckeditor' => array(
                    'js' => array(
                        'lib/ckeditor-4.2/ckeditor.js',
                    ),
                ),
                'jquery' => array(
                    'js' => array(
                        'lib/jquery/jquery-1.10.2.min.js',
                        'lib/jquery-ui-1.10.3/ui/minified/jquery.ui.widget.min.js',
                    ),
                    'css' => array(
                        'lib/jquery-ui-1.10.3/themes/base/minified/jquery-ui.min.css',
                    ),
                ),
                'jquery.jqgrid' => array(
                    'js' => array(
                        'lib/jquery/jquery.jqGrid-4.5.2/js/jquery.jqGrid.min.js',
                        'lib/jquery/jquery.jqGrid-4.5.2/js/i18n/grid.locale-en.js',
                    ),
                    'css' => array(
                        'lib/jquery/jquery.jqGrid-4.5.2/css/ui.jqgrid.css',
                    ),
                    'depends' => array('jquery'),
                ),
                'msie' => array( // Fixes for MSIE
                    'js' => array(
                        'lib/jquery/placeholder/jquery.placeholder.min.js',
                        'lib/respond-1.3.0/respond.min.js',
                    ),
                    'css' => array(
                    ),
                    'depends' => array('jquery'),
                ),
                'plupload' => array(
                    'js' => array(
                        'lib/plupload-2.0.0-beta/js/plupload.full.min.js',
                        'lib/plupload-2.0.0-beta/js/jquery.plupload.queue/jquery.plupload.queue.min.js',
                    ),
                    'css' => array(
                    ),
                    'depends' => array('jquery'),
                ),
                'select2' => array(
                    'js' => array(
                        'lib/select2/select2.js',
                    ),
                    'css' => array(
                        'lib/select2/select2.css',
                        'lib/select2/select2-bootstrap.css'
                    ),
                    'depends' => array(
                        'jquery',
                    )
                )

            ),
        ),

        'user' => array(
            'class'             => '\web\ext\WebUser',
            'allowAutoLogin'    => true,
            'authTimeout'       => SECONDS_IN_HOUR,
            'loginUrl'          => array('/auth/login'),
        ),

        'widgetFactory' => array(
            'class'             => '\web\ext\WidgetFactory',
            'enableSkin'        => true,
            'skinnableWidgets'  => array(),
            'skinPath'          => \yii::getPathOfAlias('web.views.skins'),
            'widgets'           => array(
                'EReCaptcha' => array(
                    'theme'     => 'white',
                    'language'  => 'en',
                    'publicKey' => '6LflltkSAAAAAJWYOWCtYz0LxP11tEubd0sI6WZB'
                ),
            ),
        ),

    ),

    'modules' => array(

        'staff' => array(
            'class'                 => '\web\modules\staff\StaffModule',
            'controllerNamespace'   => 'web\modules\staff\controllers',
        ),

    ),

    // Application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(__DIR__ . '/params.php'),

);

return \CMap::mergeArray($commonConfig, $config);
