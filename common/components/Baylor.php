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
    protected $accessToken;

    /**
     * @var string
     */
    protected $personId;

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

        unlink($this->cookiesFile);

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
     * Method that handles the whole team import
     * @param string $email
     * @param string $password
     * @param string $teamId
     * @return array
     */
    public function importTeam($email, $password, $teamId)
    {
        $this->cookiesFile = \yii::getPathOfAlias('common.runtime') . '/' . uniqid('', true);
        $this->curl = new Curl;

        $this->_login($email, $password);

        $response = $this->_parseTeam($teamId);

        unlink($this->cookiesFile);

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

    public function getTeamList($email, $password)
    {
        $this->cookiesFile = \yii::getPathOfAlias('common.runtime') . '/' . uniqid('', true);
        $this->curl = new Curl;

        $this->_login($email, $password);

        $response = $this->_parseTeamList();

        unlink($this->cookiesFile);

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

    public function _parseTeamList()
    {
        // Get recent year
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-common-rest/rest/common/globals/all");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $globals = json_decode($response->body, true);

        // Get teams list
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-team/rest/team/table/search/my/{$globals['worldFinalsYear']}?q=proj:name,site,contest,status,role%3B&page=1&size=100");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $teams = json_decode($response->body, true);

        // Populate result
        $result = [];
        foreach ($teams as $team) {
            $this->populateLegaceTeamFields($team);
            $result[$team['teamId']] = $team;
        }

        return $result;
    }

    /**
     * Method that handles get request and parses data for team import
     * @param string $teamId
     * @return array|bool
     * @throws \CException
     */
    protected function _parseTeam($teamId)
    {
        // Pull team info
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-team/rest/team/teams/{$teamId}");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $team = json_decode($response->body, true);
        $this->populateLegaceTeamFields($team);

        // Pull team members
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-team/rest/team/members/team/{$teamId}");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $members = json_decode($response->body, true);
        $team['members'] = [];
        foreach ($members as $member) {

            // Skip NOT contestants or reserve
            if (!in_array($member['role'], ['CONTESTANT', 'RESERVE'])) {
                continue;
            }

            // Push member
            $team['members'][] = [
                'name'  => $member['name'],
                'email' => $member['email'],
                'role'  => $member['role'],
                'isRegistrationComplete' => $member['registrationComplete'],
            ];
        }

        // Order members by role ("CONTESTANT" should be first, "RESERVE" - at the end)
        usort($team['members'], function($a, $b) {
            if ($a['role'] === 'CONTESTANT') {
                return -1;
            } else {
                return 1;
            }
        });

        return [
            'team' => $team,
        ];
    }

    /**
     * Populate legacy array fields
     * @param array $team
     */
    protected function populateLegaceTeamFields(array &$team)
    {
        $team['title']  = $team['name'];
        $team['id']     = isset($team['id']) ? $team['id'] : $team['teamId'];
        $team['url']    = "{$this->url}/cm5-team/rest/team/members/team/{$team['id']}";
    }

    /**
     * Method that clears sting from empty symbols
     * @param string $string
     * @return string
     */
    protected function clear($string)
    {
        $result = $string;

        $result = str_replace(array(' ', "\n", "\t", "\r", chr(0xC2).chr(0xA0)), '', $result);
        $result = trim($result, " ".chr(0xC2).chr(0xA0));

        return $result;
    }

    /**
     * Method that handles login request
     * @param string $email
     * @param string $password
     */
    protected function _login($email, $password)
    {
        // Skip if already loggedin
        if (!empty($this->accessToken)) {
            return;
        }

        // Pull login page
        $curl = $this->curl->newRequest('GET', $this->url . '/auth/realms/cm5/protocol/openid-connect/auth?client_id=cm5-frontend&redirect_uri=https%3A%2F%2Ficpc.baylor.edu%2Fprivate&state=16541073-4e33-4f65-8b11-08b65cd3b621&response_mode=fragment&response_type=code&scope=openid&nonce=fdb2a01d-3764-43aa-931f-668aaffa5ecb');
        $response = $this->_setBaylorHeadersAndOptions($curl, $this->cookiesFile)->send();

        // Parse login form action manually due to HTML errors
        preg_match('/kc-form-login.*action="(.*)" /', $response->body, $matches);
        $loginUrl = html_entity_decode($matches[1]);

        // Login
        $curl = $this->curl->newRequest('POST', $loginUrl, [
            'username' => $email,
            'password' => $password,
        ]);
        $response = $this->_setBaylorHeadersAndOptions($curl, $this->cookiesFile)->send();
        $redirectUrl = parse_url($response->headers['Location']);
        parse_str($redirectUrl['fragment'], $redirectParams);

        // Get token
        $curl = $this->curl->newRequest('POST', $this->url . '/auth/realms/cm5/protocol/openid-connect/token', [
            'code'          => $redirectParams['code'],
            'grant_type'    => 'authorization_code',
            'client_id'     => 'cm5-frontend',
            'redirect_uri'  => $this->url . '/private',
        ]);
        $response = $this->_setBaylorHeadersAndOptions($curl, $this->cookiesFile)->send();
        $json = json_decode($response->body);
        $this->accessToken = $json->access_token;

        // Get profile ID
        $cookies = file_get_contents($this->cookiesFile);
        preg_match('/KEYCLOAK_SESSION	cm5\/f:.*:(.*)\//', $cookies, $matches);
        $this->personId = $matches[1];
    }

    /**
     * Method that handles get request and parses data
     * @return array|bool
     * @throws \CException
     */
    protected function _parse()
    {
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-person/rest/person/person/name/{$this->personId}");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $account = json_decode($response->body, true);
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-person/rest/person/person/{$this->personId}");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $person = json_decode($response->body, true);
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-person/rest/person/contactinfo/person/{$this->personId}");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $contacts = json_decode($response->body, true);
        $getCurl = $this->curl->newRequest('GET', "{$this->url}/cm5-person/rest/person/degree/person/{$this->personId}");
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $degree = json_decode($response->body, true);
        $info = [
            'baylor_id'     => $person['id'],
            'firstName'     => $person['personInfo']['firstName'],
            'lastName'      => $person['personInfo']['lastName'],
            'shirtSize'     => $person['personInfo']['shirtSize'],
            'birthday'      => $person['personInfo']['dateOfBirth'],
            'phoneMobile'   => $contacts['voice'],
            'officeAddress' => $contacts['shippingAddress']['addressLine1'],
            'email'         => $account['username'],
            'speciality'    => $degree['degreePursued'],
            'acmId'         => '',
        ];

        return $info;
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
        if (!empty($this->accessToken)) {
            $curl->setHeader('Authorization', "Bearer {$this->accessToken}");
        } else {
            $curl
                ->setHeader('User-Agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36')
                ->setHeader('Accept', 'ext/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8')
                ->setHeader('Accept-Language', 'en-US,en;q=0.8,ru;q=0.6,uk;q=0.4')
                ->setHeader('Cache-Control', 'max-age=0')
                ->setHeader('Connection', 'keep-alive')
                ->setHeader('Content-Type', 'application/x-www-form-urlencoded')
                ->setHeader('Host', 'icpc.baylor.edu')
                ->setHeader('Origin', $this->url)
                ->setHeader('Referer', $this->url)
                ->setOptions(array(
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_COOKIEFILE => $cookies,
                    CURLOPT_COOKIEJAR => $cookies
                ))
            ;
        }

        return $curl;
    }

}