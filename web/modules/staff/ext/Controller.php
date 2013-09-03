<?php

namespace web\modules\staff\ext;

use \common\models\User;

class Controller extends \web\ext\Controller
{

    /*
     * Search operation name for daterange field type
     */
    const  JQGRID_OPERATION_DATERANGE = 'dr';

    /**
     * Get jqGrid params
     *
     * @param \common\ext\MongoDb\Document $model
     * @param \EMongoCriteria $criteria
     * @return array
     */
    protected function _getJqgridParams(\common\ext\MongoDb\Document $model, \EMongoCriteria $criteria = null)
    {
        // Get params
        $page       = (int)$this->request->getParam('page', 1);
        $perPage    = (int)$this->request->getParam('rows', 10);
        $sortName   = $this->request->getParam('sidx', 'time');
        $sortOrder  = ($this->request->getParam('sord', 'desc') == 'desc') ? \EMongoCriteria::SORT_DESC : \EMongoCriteria::SORT_ASC;
        $filters    = $this->request->getParam('filters');

        // Get items
        if ($criteria === null) {
            $criteria = new \EMongoCriteria();
        }
        $criteria
            ->sort($sortName, $sortOrder)
            ->limit($perPage)
            ->offset(($page - 1) * $perPage);
        if ($filters) {
            $filters = json_decode($filters);

            foreach ($filters->rules as $filter) {

                // Specify criteria for datarange field
                if ($filter->op === static::JQGRID_OPERATION_DATERANGE) {
                    $dateRange = explode('-', $filter->data);
                    $day = SECONDS_IN_DAY;
                    $startDate = strtotime($dateRange[0] . ' UTC');

                    // Specify end date as the date increased by on one day
                    $endDate = $startDate + $day;
                    if (isset($dateRange[1])) {
                        $endDate = strtotime($dateRange[1] . ' UTC') + $day;
                    }

                    $criteria->addCond($filter->field, '>=', $startDate);
                    $criteria->addCond($filter->field, '<=', $endDate);
                } else {
                    $regex = new \MongoRegex('/'.preg_quote($filter->data).'/i');
                    $criteria->addCond($filter->field, '==', $regex);
                }

            }
        }
        $itemList   = $model->findAll($criteria);
        $totalCount = $model->count($criteria);

        // Return params
        return array(
            'page'      => $page,
            'perPage'   => $perPage,
            'itemList'  => $itemList,
            'totalCount'=> $totalCount,
        );
    }

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Check access
        if ((!\yii::app()->user->isGuest) && (!\yii::app()->user->checkAccess(User::ROLE_ADMIN))) {
            return $this->httpException(403);
        } elseif ((\yii::app()->user->isGuest) && ($this->id !== 'auth')) {
            return $this->redirect(array('/auth/login'));
        }
    }

}