<?php

namespace web\modules\staff\widgets;

use \common\ext\MongoDb\Auth as Auth;

/**
 * Renders RBAC items list
 */
class RbacAuthItems extends \web\ext\Widget
{

    /**
     * Type of items
     * @var string
     */
    public $itemsType;

    /**
     * Current role
     * @var Auth\Item
     */
    public $role;

    /**
     * Run widget
     */
    public function run()
    {
        // Create empty role
        if (!$this->role) {
            $this->role = new Auth\Item();
            $this->role->type = \CAuthItem::TYPE_ROLE;
        }

        // Get list items
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('type', '==', $this->itemsType)
            ->sort('name', \EMongoCriteria::SORT_ASC);
        $itemList = Auth\Item::model()->findAll($criteria);

        // Render view
        $this->render('rbacAuthItems', array(
            'itemList' => $itemList,
        ));
    }

}