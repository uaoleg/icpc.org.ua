<?php

namespace frontend\widgets;

class BaylorModal extends BaseWidget {

    /**
     * Run widget
     *
     * @throws \CException
     */
    public function run()
    {
        return $this->render('baylorModal');
    }

}