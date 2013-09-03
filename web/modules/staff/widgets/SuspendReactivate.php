<?php

namespace web\modules\staff\widgets;

use \common\models\User\Customer as Customer;

/**
 * Renders suspend-reactivate customer widget
 */
class SuspendReactivate extends \web\ext\Widget
{

    /**
     * Customer
     * @var Customer
     */
    public $customer;

    /**
     * Run widget
     */
    public function run()
    {
        // Get list of related abuses
        $criteria = new \EMongoCriteria();
        $criteria
            ->addCond('objectId', '==', $this->customer->getUniqueId())
            ->sort('date', \EMongoCriteria::SORT_DESC);
        $abuseList = \common\models\Abuse::model()->findAll($criteria);

        // Render view
        $this->render('suspendReactivate', array(
            'abuseList' => $abuseList,
        ));
    }

}