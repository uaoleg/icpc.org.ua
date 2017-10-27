<?php

namespace frontend\widgets;

/**
 * Renders navigation menu
 */
class Nav extends BaseWidget
{

    /**
     * List of menu items
     * <pre>
     * array(
     *     'inbox' => array(
     *         'href'       => Url::toRoute(['/inbox/message/inbox']),
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
    public $cssClass = 'nav';

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
            if (\yii::$app->user->can($item['rbac'])) {
                continue;
            }
            unset($this->itemList[$itemId]);
        }

        // Render view
        return $this->render('nav', [
            'itemList'      => $this->itemList,
            'activeItem'    => $this->activeItem,
            'cssClass'      => $this->cssClass,
        ]);
    }

}