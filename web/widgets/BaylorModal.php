<?php

namespace web\widgets;

use web\ext\Widget;

class BaylorModal extends Widget {

    /**
     * Run widget
     *
     * @throws \CException
     */
    public function run()
    {
        $this->render('baylorModal');
    }

}