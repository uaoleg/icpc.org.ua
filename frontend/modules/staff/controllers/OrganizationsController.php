<?php

namespace frontend\modules\staff\controllers;

use \common\models\School;
use \frontend\modules\staff\search\OrganizationSearch;

class OrganizationsController extends \frontend\modules\staff\ext\Controller
{

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Set active main menu item
        $this->setNavActiveItem('main', 'admin');
    }

    /**
     * Main page
     */
    public function actionIndex()
    {
        // Get list of students
        $search = new OrganizationSearch;
        $provider = $search->search(\yii::$app->request->queryParams);

        // Render view
        return $this->render('index', array(
            'provider'  => $provider,
            'search'    => $search,
        ));
    }

    /**
     * Save single record
     */
    public function actionSave()
    {
        // Get params
        $id             = \yii::$app->request->get('id');
        $operation      = \yii::$app->request->get('oper');
        $fullNameUk     = \yii::$app->request->get('fullNameUk');
        $shortNameUk    = \yii::$app->request->get('shortNameUk');
        $fullNameEn     = \yii::$app->request->get('fullNameEn');
        $shortNameEn    = \yii::$app->request->get('shortNameEn');
        $type           = \yii::$app->request->get('type');

        // Save
        switch ($operation) {
            case 'edit':
                $school = School::findOne($id);
                foreach ($school->attributeNames() as $attrName) {
                    $attrValue = \yii::$app->request->get($attrName);
                    if ($attrValue !== null) {
                        $school->{$attrName} = $attrValue;
                    }
                }
                $school->save();
                break;
        }
    }

}
