<?php

namespace web\widgets\document;

/**
 * Renders document icon
 */
class Icon extends \web\ext\Widget
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
        $this->render('icon', array(
            'icon' => $icon,
        ));
    }

}