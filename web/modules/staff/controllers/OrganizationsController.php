<?php

namespace web\modules\staff\controllers;

use \common\models\School;
use EMongoCriteria;

class OrganizationsController extends \web\modules\staff\ext\Controller
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
        // Get list of available types
        $types = array();
        $typesForSearch = array(
            ':' . \yii::t('app', 'All'),
        );
        foreach (School::model()->getConstantList('TYPE_') as $type) {
            $types[$type] = School::model()->getAttributeLabel($type, 'type');
            $typesForSearch[] = $type . ':' . School::model()->getAttributeLabel($type, 'type');
        }

        // Render view
        $this->render('index', array(
            'types'             => $types,
            'typesForSearch'    => $typesForSearch,
        ));
    }

    /**
     * Get list of organizations for jqGrid
     */
    public function actionGetList()
    {
        // Get jqGrid params
        $jqgrid = $this->_getJqgridParams(School::model());

        // Fill rows
        $rows = array();
        /* @var $school School */
        foreach ($jqgrid['itemList'] as $school) {
            $rows[] = array(
                'id'   => (string)$school->_id,
                'cell' => array(
                    $school->fullNameUk,
                    $school->shortNameUk,
                    $school->fullNameEn,
                    $school->shortNameEn,
                    $school->getAttributeLabel($school->type, 'type'),
                    $school->stateLabel,
                ),
            );
        }

        // Render json
        $this->renderJson(array(
            'page'      => $jqgrid['page'],
            'total'     => ceil($jqgrid['totalCount'] / $jqgrid['perPage']),
            'records'   => count($jqgrid['itemList']),
            'rows'      => $rows,
        ));
    }

    /**
     * Save single record
     */
    public function actionSave()
    {
        // Get params
        $id             = $this->request->getParam('id');
        $operation      = $this->request->getParam('oper');
        $fullNameUk     = $this->request->getParam('fullNameUk');
        $shortNameUk    = $this->request->getParam('shortNameUk');
        $fullNameEn     = $this->request->getParam('fullNameEn');
        $shortNameEn    = $this->request->getParam('shortNameEn');
        $type           = $this->request->getParam('type');

        // Save
        switch ($operation) {
            case 'edit':
                $school = School::model()->findByPk(new \MongoId($id));
                foreach ($school->attributeNames() as $attrName) {
                    $attrValue = $this->request->getParam($attrName);
                    if ($attrValue !== null) {
                        $school->{$attrName} = $attrValue;
                    }
                }
                $school->save();
                break;
        }
    }

}
