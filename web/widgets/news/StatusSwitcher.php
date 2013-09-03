<?php

namespace web\widgets\news;

/**
 * Renders status switcher
 */
class StatusSwitcher extends \web\ext\Widget
{

    /**
     * News item
     * @var \common\models\News
     */
    public $news;

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        $this->render('statusSwitcher');
    }

}