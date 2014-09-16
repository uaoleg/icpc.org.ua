<?php

namespace web\modules\test\ext;

class Controller extends \web\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        // Check environment
        if (APP_ENV === APP_ENV_PROD) {
            $this->httpException(403);
        }

        parent::init();
    }

}