<?php

namespace web\modules\staff\ext;

use \common\models\User;

class Controller extends \web\ext\Controller
{

    /**
     * Returns the access rules for this controller
     *
     * @return array
     */
    public function accessRules()
    {
        return array_merge(parent::accessRules(), array(
            array(
                'allow',
                'controllers' => array(
                    'staff/coaches',
                    'staff/coordinators',
                    'staff/news',
                    'staff/students',
                    'staff/students/export',
                    'staff/reports',
                    'staff/qaTags',
                ),
                'roles' => array(User::ROLE_COORDINATOR_STATE),
            ),
            array(
                'allow',
                'controllers'   => array(
                    'staff/lang',
                    'staff/organizations',
                ),
                'roles'         => array(User::ROLE_ADMIN),
            ),
            array(
                'deny',
            ),
        ));
    }

}