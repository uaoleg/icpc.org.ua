<?php

namespace web\widgets\news;

/**
 * Renders news date published
 */
class Date extends \web\ext\Widget
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
        $this->render('date');
    }

}