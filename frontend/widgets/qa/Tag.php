<?php

namespace frontend\widgets\qa;

use \frontend\widgets\BaseWidget;

/**
 * Renders tag
 */
class Tag extends BaseWidget
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
        return $this->render('tag', [
            'tag' => $this->tag,
        ]);
    }


}