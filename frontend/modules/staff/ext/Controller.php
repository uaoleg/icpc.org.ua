<?php

namespace frontend\modules\staff\ext;

use \common\models\User;

class Controller extends \frontend\controllers\BaseController
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
                    'staff/qatags',
                ),
                'roles' => array(User::ROLE_COORDINATOR_STATE),
            ),
            array(
                'allow',
                'controllers'   => array(
                    'staff/organizations',
                ),
                'roles' => array(User::ROLE_COORDINATOR_UKRAINE),
            ),
            array(
                'allow',
                'controllers'   => array(
                    'staff/lang',
                ),
                'roles' => array(User::ROLE_ADMIN),
            ),
            array(
                'deny',
            ),
        ));
    }

}