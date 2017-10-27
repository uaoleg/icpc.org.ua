<?php

namespace common\controllers;

use \yii\base\InlineAction;
use \yii\db\ActiveQuery;
use \yii\helpers\ArrayHelper;
use \yii\helpers\Json;
use \yii\helpers\Html;

/**
 * Base controller
 */
class BaseController extends \yii\web\Controller
{

    /*
     * Search operation names for different field types
     */
    const JQGRID_OPERATION_DATERANGE = 'dr';
    const JQGRID_OPERATION_GREATER_OR_EQUAL = 'ge';
    const JQGRID_OPERATION_EQUAL_BOOL = 'bool';
    const JQGRID_OPERATION_EQUAL_BOOL_DATA_NONE = '-1';

    /**
     * Nav active items
     * @var array
     * @see setNavActiveItem()
     * @see getNavActiveItem()
     */
    protected $_navActiveItems = array();

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
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                    ],
                ],
            ],
        ]);
    }

    /**
     * Creates an action based on the given action ID.
     * @param string $id the action ID.
     * @return Action the newly created action instance. Null if the ID doesn't resolve into any action.
     */
    public function createAction($id)
    {
        parent::createAction($id);
        if ($id === '') {
            $id = $this->defaultAction;
        }

        $actionMap = $this->actions();
        if (isset($actionMap[$id])) {
            return \yii::createObject($actionMap[$id], [$id, $this]);
        } elseif (preg_match('/^[a-z0-9\\-_]+$/', $id) && strpos($id, '--') === false && trim($id, '-') === $id) {
            $methodName = 'action' . str_replace(' ', '', ucwords(implode(' ', explode('-', $id))));
            $verbMethodName = mb_strtolower(\yii::$app->request->getMethod()) . ucfirst($methodName);
            if (method_exists($this, $verbMethodName)) {
                $methodName = $verbMethodName;
            }
            if (method_exists($this, $methodName)) {
                $method = new \ReflectionMethod($this, $methodName);
                if ($method->isPublic() && $method->getName() === $methodName) {
                    return new InlineAction($id, $this, $methodName);
                }
            }
        }

        return null;
    }

    /**
     * After action
     * @param \yii\web\Action $action the action just executed.
     * @param mixed $result the action return result.
     * @return mixed the processed action result.
     */
    public function afterAction($action, $result)
    {
        // Remember last visited URL
        if (($this->id !== 'auth') && (!\yii::$app->request->isAjax)) {
            \yii::$app->user->setState('last-visited-url',  \yii::$app->request->url);
        }

        return parent::afterAction($action, $result);
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
     * Returns JSON response
     * @param array $params
     * @return array
     */
    public function renderJson(array $params)
    {
        \yii::$app->response->format = 'json';

        ob_start();
        ob_implicit_flush(false);
        $this->view->beginPage();
        $this->view->head();
        $this->view->beginBody();
        $this->view->endBody();
        $this->view->endPage(true);
        $params['__scripts__'] = ob_get_clean();

        return $params;
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
            $data = ArrayHelper::htmlEncode($data);
        } elseif (is_string($data)) {
            $data = Html::encode($data);
        }
        $json = Json::encode($data);
        return Html::encode($json);
    }

    /**
     * Returns geo (News, Results, etc.)
     *
     * @return string
     */
    public function getGeo()
    {
        // Get saved year
        if (\yii::$app->user->isGuest) {
            $defaultGeo = \yii::$app->user->getState('geo');
        } else {
            $defaultGeo = \yii::$app->user->identity->settings->geo;
        }

        // Get params
        $geo = \yii::$app->request->get('geo', $defaultGeo);

        // Get default value
        if (empty($geo)) {
            $geo = (new \common\models\School)->country;
        }

        // Save the geo to the user's settings
        if (\yii::$app->user->isGuest) {
            \yii::$app->user->setState('geo', $geo);
        } else {
            $settings = \yii::$app->user->identity->settings;
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
        if (\yii::$app->user->isGuest) {
            $defaultYear = \yii::$app->user->getState('year');
        } else {
            $defaultYear = \yii::$app->user->identity->settings->year;
        }

        // Get params
        $year = (int)\yii::$app->request->get('year', $defaultYear);

        // Check range
        if (($year < (int)\yii::$app->params['yearFirst']) || ($year > (int)date('Y'))) {
            $year = (int)date('Y');
        }

        // Save the year to the user's settings
        if (\yii::$app->user->isGuest) {
            \yii::$app->user->setState('year', $year);
        } else {
            $settings = \yii::$app->user->identity->settings;
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
        \yii::$app->user->setState('nav-active-items', $this->_navActiveItems);
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
     * @throws \yii\web\HttpException
     */
    public function httpException($status, $message = null, $code = 0)
    {
        throw new \yii\web\HttpException($status, $message, $code);
    }

    /**
     * Get jqGrid params
     *
     * @param string $class
     * @param ActiveQuery $query
     * @return array
     */
    protected function _getJqgridParams($class, ActiveQuery $query = null)
    {
        // Get params
        $page       = (int)\yii::$app->request->get('page', 1);
        $perPage    = (int)\yii::$app->request->get('rows', 10);
        $sortName   = \yii::$app->request->get('sidx', 'time');
        $sortOrder  = (\yii::$app->request->get('sord', 'desc') == 'desc') ? \SORT_DESC : \SORT_ASC;
        $filters    = \yii::$app->request->get('filters');

        // Get items
        if ($query === null) {
            $query = $class::find();
        }
        if (!empty($sortName)) {
            $query->orderBy([$sortName => $sortOrder]);
        }
        $query
            ->limit($perPage)
            ->offset(($page - 1) * $perPage);
        if ($filters) {
            $filters = json_decode($filters);

            foreach ($filters->rules as $filter) {

                // Specify conditions for datarange field
                if ($filter->op === static::JQGRID_OPERATION_DATERANGE) {
                    $dateRange = explode('-', $filter->data);
                    $day = SECONDS_IN_DAY;
                    $startDate = strtotime($dateRange[0] . ' UTC');

                    // Specify end date as the date increased by on one day
                    $endDate = $startDate + $day;
                    if (isset($dateRange[1])) {
                        $endDate = strtotime($dateRange[1] . ' UTC') + $day;
                    }

                    $query->andWhere(['>=', $filter->field, $startDate]);
                    $query->andWhere(['<=', $filter->field, $endDate]);
                } elseif ($filter->op === static::JQGRID_OPERATION_GREATER_OR_EQUAL) {
                    $query->andWhere(['>=', $filter->field, (int)$filter->data]);
                } elseif ($filter->op === static::JQGRID_OPERATION_EQUAL_BOOL) {
                    if ($filter->data !== static::JQGRID_OPERATION_EQUAL_BOOL_DATA_NONE) {
                        $query->andWhere(['==', $filter->field, (bool)$filter->data]);
                    }
                } else {
                    $query->andWhere(['LIKE', $filter->field, $filter->data]);
                }

            }
        }

        // Return params
        return array(
            'query'     => $query,
            'page'      => $page,
            'perPage'   => $perPage,
            'itemList'  => $query->all(),
            'totalCount'=> (int)$query->count(),
        );
    }

    /**
     * Logs event
     * @param string $logClass
     * @param array $attributes
     * @see \common\models\Log\BaseLog
     */
    public function logEvent($logClass, array $attributes)
    {
        /* @var $event \common\models\Log\BaseLog */
        $event = new $logClass();
        $event->setAttributes(ArrayHelper::merge($attributes, [
            'userId'    => \yii::$app->user->id ?: null,
            'userIp'    => \yii::$app->request->userIP,
            'userAgent' => \yii::$app->request->userAgent,
        ]), false);
        $event->save();
    }

}
