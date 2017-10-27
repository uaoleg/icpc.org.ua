<?php

namespace frontend\widgets\document;

use \frontend\widgets\BaseWidget;

/**
 * Renders document row
 */
class Row extends BaseWidget
{

    /**
     * Document
     * @var \common\models\Document
     */
    public $document;

    /**
     * Redirect after document deleted
     * @var string
     */
    public $afterDeleteRedirect = '';

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        return $this->render('row', [
            'document'              => $this->document,
            'afterDeleteRedirect'   => $this->afterDeleteRedirect,
        ]);
    }

}