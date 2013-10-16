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
        switch (APPLICATION_ENV) {
            case 'acceptance':
                $this->render('googleAnalyticsAcceptance');
                break;
            case 'production':
                $this->render('googleAnalyticsProduction');
                break;
            default:
                return;
                break;
        }
    }

}