<?php

namespace web\widgets;

/**
 * Renders Application Environment label for development and production
 */
class AppEnv extends \web\ext\Widget
{

    /**
     * Run widget
     */
    public function run()
    {
        // Don't show label on production
        if (APP_ENV === APP_ENV_PROD) {
            return;
        }

        // Render view
        $this->render('appEnv');
    }

}