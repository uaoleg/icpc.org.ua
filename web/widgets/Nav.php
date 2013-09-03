<?php

namespace web\widgets;

/**
 * Renders navigation menu
 */
class Nav extends \web\ext\Widget
{

    /**
     * List of menu items
     * <pre>
     * array(
     *     'inbox' => array(
     *         'href'       => \yii::app()->urlManager->createUrl('/inbox/message/inbox'),
     *         'caption'    => \yii::t('app', 'Inbox'),
     *         'icon'       => 'icon-message',
     *         'iconImg'    => 'icon-message.png',
     *         'rbac'       => null,
     *     ),
     *     'anotherItemId' => ...
     * )
     * </pre>
     * @var array
     */
    public $itemList = array();

    /**
     * ID of the active item
     * @var string
     */
    public $activeItem;

    /**
     * Bootstrap class
     * @var string
     */
    public $class = 'nav';

    /**
     * Run widget
     */
    public function run()
    {
        // Remove items without access
        foreach ($this->itemList as $itemId => $item) {
            if ($item === null) {
                unset($this->itemList[$itemId]);
                continue;
            }
            if (!isset($item['rbac'])) {
                continue;
            }
            if (\yii::app()->rbac->checkAccess($item['rbac'])) {
                continue;
            }
            unset($this->itemList[$itemId]);
        }

        // Render view
        $this->render('nav');
    }

}