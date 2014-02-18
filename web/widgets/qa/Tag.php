<?php

namespace web\widgets\qa;

/**
 * Renders tag
 */
class Tag extends \web\ext\Widget
{

    /**
     * Tag
     * @var string
     */
    public $tag;

    /**
     * Run widget
     */
    public function run()
    {
        // Render view
        $this->render('tag');
    }


}