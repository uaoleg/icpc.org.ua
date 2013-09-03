<?php

namespace web\ext;

class HttpRequest extends \CHttpRequest
{

    /**
     * Get real IP
     *
     * @return string
     */
    public function getRealIp()
    {
        // Check IP from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        // Check IP is passed from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = trim(end(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])));
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        }

        // Default IP
        else {
            $ip = \yii::app()->request->userHostAddress;
        }

        return $ip;
    }

    /**
     * If user agent is IE
     *
     * @return bool
     */
    public function userAgentIsIe()
    {
        return stripos(\yii::app()->request->userAgent, 'msie') !== false;
    }

    /**
     * If user agent is Safari
     *
     * @return bool
     */
    public function userAgentIsSafari()
    {
        return stripos(\yii::app()->request->userAgent, 'safari') !== false;
    }

    /**
     * Check if user browser accept type has a given one
     *
     * @param string $type
     * @return bool
     */
    public function hasAcceptType($type)
    {
        $accept = $this->getAcceptTypes();
        if ($accept === null) {
            return false;
        }
        $acceptList = explode(';', $accept);
        $acceptList = explode(',', $acceptList[0]);
        return in_array($type, $acceptList);
    }

    /**
     * Accept type is HTML
     *
     * @return bool
     */
    public function getIsAcceptHtml()
    {
        return $this->hasAcceptType('text/html');
    }

    /**
     * Accept type is text
     *
     * @return bool
     */
    public function getIsAcceptText()
    {
        return $this->hasAcceptType('text/plain');
    }

    /**
     * Accept type is json
     *
     * @return bool
     */
    public function getIsAcceptJson()
    {
        return $this->hasAcceptType('application/json');
    }

    /**
     * Accept type is XML
     *
     * @return bool
     */
    public function getIsAcceptXml()
    {
        return $this->hasAcceptType('application/xml');
    }

}