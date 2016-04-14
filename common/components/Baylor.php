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
     * Method that handles the whole team import
     * @param string $email
     * @param string $password
     * @param string $team_id
     * @return array
     */
    public function importTeam($email, $password, $team_id)
    {
        $this->cookiesFile = \yii::getPathOfAlias('common.runtime') . '/' . uniqid('', true);
        $this->curl = new Curl;

        $this->_login($email, $password);

        $response = $this->_parseTeam($team_id);

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
        $result = array();

        // Import HTML DOM Parser
        \yii::import('common.lib.HtmlDomParser.*');
        require_once('HtmlDomParser.php');
        $parser = new HtmlDomParser();

        //Get Teams list
        $getCurl = $this->curl->newRequest('POST', $this->url . '/private/team/yourTeamList.icpc', array(

            // Setting number of rows
            'javax.faces.partial.ajax'      => 'true',
            'javax.faces.source'            => 'teamMemberForm:teamMembers',
            'javax.faces.partial.execute'   => 'teamMemberForm:teamMembers',
            'javax.faces.partial.render'    => 'teamMemberForm:teamMembers',
            'teamMemberForm:teamMembers'    => 'teamMemberForm:teamMembers',
            'teamMemberForm:teamMembers_pagination' => 'true',
            'teamMemberForm:teamMembers_first'      => '0',
            'teamMemberForm:teamMembers_rows'       => '50',
            'teamMemberForm:teamMembers_encodeFeature'  => 'true',
            'teamMemberForm'                            => 'teamMemberForm',
            'javax.faces.ViewState'                     => '9135935228831978634:-6291211713543351310',

            // Setting year
            'teamCreateButton:yearSelectorForm'         => 'teamCreateButton:yearSelectorForm',
            'teamCreateButton:yearSelectorForm:year'    => date('Y') + 1,
            'javax.faces.ViewState'                     => '9135935228831978634:-6291211713543351310',
            'javax.faces.source:teamCreateButton'       => 'yearSelectorForm:year',
            'javax.faces.partial.event'                 => 'change',
            'javax.faces.partial.execute'               => 'teamCreateButton:yearSelectorForm:year',
            'javax.faces.partial.render'                => 'teamMemberForm',
            'javax.faces.behavior.event'                => 'change',
            'javax.faces.partial.ajax'                  => 'true',
        ));
        $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
        $xml = simplexml_load_string($response->body, 'SimpleXMLElement', LIBXML_NOCDATA);
        $elements = (array)$xml->changes->update;
        $html = $parser->str_get_html($elements[1]);
        $rows = $html->find('a.team');
        foreach ($rows as $item) {
            $id = substr($item->href, strlen('/private/team/'));
            $result[$id] = array(
                'title' => $item->plaintext,
                'id'    => $id,
                'url'   => $item->href,
            );
        }

        return $result;
    }

    /**
     * Method that handles get request and parses data for team import
     * @param string $team_id
     * @return array|bool
     * @throws \CException
     */
    protected function _parseTeam($team_id)
    {
        $result = array();

        // Import HTML DOM Parser
        \yii::import('common.lib.HtmlDomParser.*');
        require_once('HtmlDomParser.php');
        $parser = new HtmlDomParser();

        $teams = $this->_parseTeamList();
        $result['teams'] = $teams;

        if (!empty($teams[$team_id])) {

            //Get information about team
            $team = $teams[$team_id];
            $url = $team['url'];

            $getCurl = $this->curl->newRequest('get', $this->url . $url);
            $response = $this->_setBaylorHeadersAndOptions($getCurl, $this->cookiesFile)->send();
            $html = $parser->str_get_html($response->body);
            $header = $html->find('#header', 0);

            if (!is_null($header)) {

                $status = $html->find('[id="teamTabs:teamForm:statusRO"] div.statusModification span.statusACCEPTED', 0);
                $team['status'] = !empty($status) ? \web\modules\staff\controllers\TeamController::BAYLOR_STATUS_ACCEPTED : false;

                $rows = $html->find('[id="teamMembersTabs:teamMembersForm:teamMembersTable_data"] tr');
                if (!empty($rows)) {

                    foreach ($rows as $row)
                    {
                        $tds = $row->find('td');
                        $isRegistrationComplete = trim($tds[3]->find('input',0)->checked, chr(0xC2).chr(0xA0));
                        $team['members'][] = array(
                            'name' => trim($tds[0]->plaintext, " ".chr(0xC2).chr(0xA0)),
                            'email' => $this->clear($tds[1]->plaintext),
                            'role' => trim($tds[2]->plaintext, " ".chr(0xC2).chr(0xA0)),
                            'isRegistrationComplete' => !empty($isRegistrationComplete),
                        );
                    }

                }

                $result['team'] = $team;
            }

            //-----//
        }

        return $result;
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


            $id = $html->find('[id="logoffMenu:profile"]', 0);
            if (!empty($id)) {
                $baylorInfo['baylor_id'] = (int)substr($id->href, 17);
            } else {
                $baylorInfo['baylor_id'] = 0;
            }

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