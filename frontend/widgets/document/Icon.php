<?php

namespace frontend\widgets\document;

use \frontend\widgets\BaseWidget;

/**
 * Renders document icon
 */
class Icon extends BaseWidget
{

    /**
     * Document
     * @var \common\models\document
     */
    public $document;

    /**
     * Run widget
     */
    public function run()
    {
        // Define icon name
        switch ($this->document->fileExt) {
            default:
                $icon = 'default';
                break;
        }

        // Render view
        return $this->render('icon', array(
            'icon' => $icon,
        ));
    }

}