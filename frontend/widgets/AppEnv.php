<?php

namespace frontend\widgets;

/**
 * Renders Application Environment label for development and production
 */
class AppEnv extends BaseWidget
{

    /**
     * Run widget
     */
    public function run()
    {
        // Don't show label on production
        if (\YII_ENV === \YII_ENV_PROD) {
            return;
        }

        // Render view
        return $this->render('appEnv');
    }

}