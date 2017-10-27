<?php

namespace frontend\widgets\news;

use \frontend\widgets\BaseWidget;

/**
 * Renders status switcher
 */
class StatusSwitcher extends BaseWidget
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
        return $this->render('statusSwitcher', [
            'news'      => $this->news,
            'btnSize'   => $this->btnSize,
        ]);
    }

}