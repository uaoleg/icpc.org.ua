<?php

namespace frontend\widgets\news;

use \frontend\widgets\BaseWidget;

/**
 * Renders news date published
 */
class Date extends BaseWidget
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
        return $this->render('date', [
            'news' => $this->news,
        ]);
    }

}