<?php

namespace common\components;

use \Sunra\PhpSimple\HtmlDomParser;
use \anlutro\cURL\cURL as Curl;
use \anlutro\cURL\Request as CurlRequest;

class Baylor extends \CApplicationComponent
{
    /**
     * @var Curl
     */
    protected $curl;

    /**
     * @var string
     */
    protected $url = 'https://icpc.baylor.edu';

    /**
     * @var string
     */
    protected $cookiesFile;

    /**
     * Method that handles the whole import
     * @param string $email
     * @param string $password
     * @return array
     */
    public function import($email, $password)
    {
        $this->cookiesFile = \yii::getPathOfAlias('common.runtime') . '/' . uniqid('', true);
        $this->curl = new Curl;

        $this->_login($email, $password);

        $response = $this->_parse();

        if ($response) {
            return array(
                'errors' => false,
                'data' => $response
            );
        } else {
            return array(
                'errors' => true
            );
        }
    }

    /**
     * Method that handles login request
     * @param string $email
     * @param string $password
     */
    protected function _login($email, $password)
    {
        $data = array(
            'login' => 'login',
            'login:registerScreenSize' => '',
            'login:loginButtons' => 'Log in',
            'login:loginButtonsScreenSize' => '1863',
            'javax.faces.ViewState' => '-7305149916852225329:-5521534327342265186',
            'login:username' => $email,
            'login:password' => $password
        );

        $postCurl = $this->curl->newRequest('post', $this->url . '/login', $data);

        $postQuery = $this->_setBaylorHeadersAndOptions($postCurl, $this->cookiesFile)->send();
    }

    /**
     * Method that handles get request and parses data
     * @return array|bool
     * @throws \CException
     */
    protected function _parse()
    {
        $getCurl = $this->curl->newRequest('get', $this->url . '/private/profile');

        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();

        // Import HTML DOM Parser
        \yii::import('common.lib.HtmlDomParser.*');
        require_once('HtmlDomParser.php');
        $parser = new HtmlDomParser();
        $html = $parser->str_get_html($response->body);

        $header = $html->find('#header', 0);
        if (!is_null($header)) {
            $baylorInfo = array();
            $info = array(
                'firstName' => '[id="tabs:piForm:ropifirstName"]',
                'lastName' => '[id="tabs:piForm:ropilastName"]',
                'shirtSize' => '[id="tabs:piForm:pishirtSizeView"]',
                'phoneHome' => '[id="tabs:contactForm:roextendedvoice"]',
                'phoneMobile' => '[id="tabs:contactForm:roextendedemergencyPhone"]',
                'officeAddress' => '[id="tabs:contactForm:roaddressaddressLine1"]',
                'email' => '[id="tabs:piForm:piusernameView"]',
                'acmId' => '[id="tabs:piForm:ropiacmId"]',
                'speciality' => '[id="tabs:piForm:rodegreeareaOfStudy"]',
                'birthday' => '[id="tabs:piForm:degreedateOfBirthView"]',
            );

            foreach ($info as $key => $value) {
                $datum = $html->find($value, 0);
                if (!is_null($datum)) {
                    $result = trim($datum->plaintext);
                    if ($key === 'birthday') {
                        $unixBirthday = strtotime(trim($datum->plaintext));
                        $result = date('Y-m-d', $unixBirthday);
                    }

                    $baylorInfo[$key] = $result;
                }
            }

            unlink($this->cookiesFile);

            return $baylorInfo;
        } else {
            return false;
        }
    }

    /**
     * Set headers for requests on icpc.baylor.edu
     *
     * @param CurlRequest $curl
     * @param $cookies
     * @return CurlRequest
     */
    protected function _setBaylorHeadersAndOptions(CurlRequest $curl, $cookies)
    {
        return $curl
            ->setHeader('User-Agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36')
            ->setHeader('Accept', 'ext/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8')
            ->setHeader('Accept-Language', 'en-US,en;q=0.8,ru;q=0.6,uk;q=0.4')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setHeader('Connection', 'keep-alive')
            ->setHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->setHeader('Host', 'icpc.baylor.edu')
            ->setHeader('Origin', 'https://icpc.baylor.edu')
            ->setHeader('Referer', 'https://icpc.baylor.edu/login')
            ->setOptions(array(
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_COOKIEFILE => $cookies,
                CURLOPT_COOKIEJAR => $cookies
            ));
    }

}