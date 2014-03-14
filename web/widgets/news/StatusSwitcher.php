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
     * Button size class (e.g. "btn-lg")
     * @var string
     */
    public $btnSize = '';

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        $this->render('statusSwitcher');
    }

}