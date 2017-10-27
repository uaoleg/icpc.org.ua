<?php

namespace frontend\modules\test\ext;

class Controller extends \frontend\controllers\BaseController
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