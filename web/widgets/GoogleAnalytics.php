<?php

namespace web\widgets;

/**
 * Renders Google Analytics script for layout
 */
class GoogleAnalytics extends \web\ext\Widget
{

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        switch (APP_ENV) {
            case APP_ENV_ACC:
                $this->render('googleAnalyticsAcceptance');
                break;
            case APP_ENV_PROD:
                $this->render('googleAnalyticsProduction');
                break;
            default:
                return;
                break;
        }
    }

}