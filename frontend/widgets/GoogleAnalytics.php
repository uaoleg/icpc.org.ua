<?php

namespace frontend\widgets;

/**
 * Renders Google Analytics script for layout
 */
class GoogleAnalytics extends BaseWidget
{

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        switch (\YII_ENV) {
            case \YII_ENV_TEST:
                return $this->render('googleAnalyticsAcceptance');
                break;
            case \YII_ENV_PROD:
                return $this->render('googleAnalyticsProduction');
                break;
            default:
                return;
                break;
        }
    }

}