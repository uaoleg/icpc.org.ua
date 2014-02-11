<?php

namespace web\ext;

use \common\models\News;
use \common\models\Team;

/**
 * Base controller
 *
 * @property-read \web\ext\HttpRequest $request
 */
class Controller extends \CController
{
    /*
     * Search operation names for different field types
     */
    const JQGRID_OPERATION_DATERANGE = 'dr';
    const JQGRID_OPERATION_GREATER_OR_EQUAL = 'ge';

    /**
     * Nav active items
     * @var array
     * @see setNavActiveItem()
     * @see getNavActiveItem()
     */
    protected $_navActiveItems = array();

    /**
     * Returns HTTP request
     *
     * @return \web\ext\HttpRequest
     */
    public function getRequest()
    {
        return \yii::app()->request;
    }

    /**
     * Init
     */
    public function init()
    {
        parent::init();

        // Generate sprite
        if (APP_ENV === APP_ENV_DEV) {
            \yii::app()->sprite->generate();
        }

        // Remember last visited URL
        if (($this->getId() != 'auth') && (!\yii::app()->request->isAjaxRequest)) {
            \yii::app()->user->setState('last-visited-url',  \yii::app()->request->url);
        }

        // Restore nav active items
        $this->_navActiveItems = \yii::app()->user->getState('nav-active-items', array());

        // Set application language and save it with the help of cookies
        if (!\yii::app()->user->isGuest) {
            $settings = \yii::app()->user->getInstance()->settings;
            if (isset($settings->lang)) {
                $this->request->cookies['language'] = new \CHttpCookie('language', $settings->lang);
            } else {
                $settings->lang = $this->request->cookies['language']->value;
                $settings->save();
            }

        }
        if (!isset($this->request->cookies['language'])) {
            $languageCodes = array_keys(\yii::app()->params['languages']);
            $langCode = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            $defaultLang = (in_array($langCode, $languageCodes)) ? $langCode : 'uk';
            $this->request->cookies['language'] = new \CHttpCookie('language', $defaultLang);
        }
        if (isset($this->request->cookies['language'])) {
            \yii::app()->language = $this->request->cookies['language']->value;
        }
    }

    /**
     * Returns the filter configurations
     *
     * @return array
     */
    public function filters()
    {
        return array_merge(parent::filters(), array(
            'accessControl',
        ));
    }

    /**
     * Action to render CSV
     *
     * @param \EMongoCursor $data
     * @param string        $fileName
     * @param \Closure      $function
     */
    public function renderCsv($data, $fileName, \Closure $function)
    {
        // Set headers
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header("Content-Disposition: attachment; filename=\"{$fileName}\"");

        // Send content
        $fileHandler = fopen('php://output', 'w');
        fwrite($fileHandler, "\xEF\xBB\xBF"); // UTF-8 BOM
        foreach ($data as $datum) {
            fputcsv($fileHandler, call_user_func($function, $datum), ',');
        }
        fclose($fileHandler);
    }

    /**
     * Render JSON response
     *
     * @param array $data
     */
    public function renderJson(array $data = array())
    {
        header('Content-type: application/json');
        echo \CJSON::encode($data);
    }

    /**
     * Safe encode array to json string
     *
     * @param mixed $data
     * @return string
     */
    public function jsonEncode($data)
    {
        if (is_array($data)) {
            $data = \CHtml::encodeArray($data);
        } elseif (is_string($data)) {
            $data = \CHtml::encode($data);
        }
        $json = \CJSON::encode($data);
        return \CHtml::encode($json);
    }

    /**
     * Returns geo (News, Results, etc.)
     *
     * @return string
     */
    public function getGeo()
    {
        // Get saved year
        if (\yii::app()->user->isGuest) {
            $defaultGeo = \yii::app()->user->getState('geo');
        } else {
            $defaultGeo = \yii::app()->user->getInstance()->settings->geo;
        }

        // Get params
        $geo = $this->request->getParam('geo', $defaultGeo);

        // Get default value
        if (empty($geo)) {
            $geo = \common\models\School::model()->country;
        }

        // Save the geo to the user's settings
        if (\yii::app()->user->isGuest) {
            \yii::app()->user->setState('geo', $geo);
        } else {
            $settings = \yii::app()->user->getInstance()->settings;
            $settings->geo = $geo;
            $settings->save();
        }

        return $geo;
    }

    /**
     * Returns year (News, Results, etc.)
     *
     * @return int
     */
    public function getYear()
    {
        // Get saved year
        if (\yii::app()->user->isGuest) {
            $defaultYear = \yii::app()->user->getState('year');
        } else {
            $defaultYear = \yii::app()->user->getInstance()->settings->year;
        }

        // Get params
        $year = (int)$this->request->getParam('year', $defaultYear);

        // Check range
        if (($year < \yii::app()->params['yearFirst']) || ($year > date('Y'))) {
            $year = 0;
        }

        // Get default value
        if ($year === 0) {
            $year = (int)date('Y');
            switch ($this->id) {
                // Find latest year with news
                case 'news':
                    $publishedOnly = !\yii::app()->user->checkAccess(\common\components\Rbac::OP_NEWS_CREATE);
                    while (News::model()->scopeByLatest($this->getGeo(), $year, $publishedOnly)->count() === 0) {
                        $year--;
                        if ($year <= \yii::app()->params['yearFirst']) {
                            break;
                        }
                    };
                    break;
                // Find latest year with teams
                case 'team':
                    while (Team::model()->countByAttributes(array('year' => $year)) === 0) {
                        $year--;
                        if ($year <= \yii::app()->params['yearFirst']) {
                            break;
                        }
                    };
                    break;
            }
        }

        // Save the year to the user's settings
        if (\yii::app()->user->isGuest) {
            \yii::app()->user->setState('year', $year);
        } else {
            $settings = \yii::app()->user->getInstance()->settings;
            $settings->year = $year;
            $settings->save();
        }

        return $year;
    }

    /**
     * Set nav active item ID
     *
     * @param string $navId Nav ID (e.g. "main", "inbox", etc.)
     * @param string $itemId
     */
    public function setNavActiveItem($navId, $itemId)
    {
        $this->_navActiveItems[$navId] = $itemId;
        \yii::app()->user->setState('nav-active-items', $this->_navActiveItems);
    }

    /**
     * Get nav active item ID
     *
     * @param string $navId Nav ID (e.g. "main", "inbox", etc.)
     * @return string
     */
    public function getNavActiveItem($navId)
    {
        if (isset($this->_navActiveItems[$navId])) {
            return $this->_navActiveItems[$navId];
        } else {
            return '';
        }
    }

    /**
     * Throws an exception caused by invalid operations of end-users
     *
     *   HTTPError
     *       HTTPClientError
     *          <ul>
     *              <li>400 - HTTPBadRequest</li>
     *              <li>401 - HTTPUnauthorized</li>
     *              <li>402 - HTTPPaymentRequired</li>
     *              <li>403 - HTTPForbidden</li>
     *              <li>404 - HTTPNotFound</li>
     *              <li>405 - HTTPMethodNotAllowed</li>
     *              <li>406 - HTTPNotAcceptable</li>
     *              <li>407 - HTTPProxyAuthenticationRequired</li>
     *              <li>408 - HTTPRequestTimeout</li>
     *              <li>409 - HTTPConfict</li>
     *              <li>410 - HTTPGone</li>
     *              <li>411 - HTTPLengthRequired</li>
     *              <li>412 - HTTPPreconditionFailed</li>
     *              <li>413 - HTTPRequestEntityTooLarge</li>
     *              <li>414 - HTTPRequestURITooLong</li>
     *              <li>415 - HTTPUnsupportedMediaType</li>
     *              <li>416 - HTTPRequestRangeNotSatisfiable</li>
     *              <li>417 - HTTPExpectationFailed</li>
     *          </ul>
     *       HTTPServerError
     *          <ul>
     *              <li>500 - HTTPInternalServerError</li>
     *              <li>501 - HTTPNotImplemented</li>
     *              <li>502 - HTTPBadGateway</li>
     *              <li>503 - HTTPServiceUnavailable</li>
     *              <li>504 - HTTPGatewayTimeout</li>
     *              <li>505 - HTTPVersionNotSupported</li>
     *          </ul>
     *
     *
     * @param int    $status HTTP status code, such as 404, 500, etc.
	 * @param string $message error message
	 * @param int    $code error code
     * @throws \CHttpException
     */
    public function httpException($status, $message = null, $code = 0)
    {
        throw new \CHttpException($status, $message, $code);
    }

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
                } elseif ($filter->op === static::JQGRID_OPERATION_GREATER_OR_EQUAL) {
                    $criteria->addCond($filter->field, '>=', (int)$filter->data);
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

}
