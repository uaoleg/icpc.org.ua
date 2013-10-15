<?php

namespace web\ext;

/**
 * Base controller
 *
 * @property-read \web\ext\HttpRequest $request
 */
class Controller extends \CController
{

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
        if (APPLICATION_ENV === 'development') {
            \yii::app()->sprite->generate();
        }

        // Remember last visited URL
        if (($this->getId() != 'auth') && (!\yii::app()->request->isAjaxRequest)) {
            \yii::app()->user->setState('last-visited-url',  \yii::app()->request->url);
        }

        // Restore nav active items
        $this->_navActiveItems = \yii::app()->user->getState('nav-active-items', array());

        // Set application language and save it with the help of cookies
        if (!isset($this->request->cookies['language'])) {
            $this->request->cookies['language'] = new \CHttpCookie('language', 'uk');
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

}