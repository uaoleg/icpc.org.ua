<?php

use \common\models\Geo\State;
use \common\models\School;

class SchoolCommand extends \console\ext\ConsoleCommand
{

    /**
     * Checks if a name contains any of forbidden words
     *
     * @param string $text
     * @return bool
     */
    protected function _hasForbiddenWords($text)
    {
        $wordList = array('коледж', 'училище', 'технікум');
        foreach ($wordList as $word) {
            if (mb_stripos($text, $word, null, "UTF-8") !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * checks if a name contains any of needed words
     *
     * @param string $text
     * @return bool
     */
    protected function _hasNeededWord($text)
    {
        $wordList = array('університет', 'академія', 'інститут');
        foreach ($wordList as $word) {
            if (mb_stripos($text, $word, null, "UTF-8") !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Parse data from vstup.info
     *
     * @param string $year
     */
    public function actionParse($year = null)
    {
        // Import HTML DOM Parser
        \yii::import('common.lib.HtmlDomParser.*');
        require_once('HtmlDomParser.php');

        // Get year
        if (empty($year)) {
            $year = date('Y');
        }
        $year = (int)$year;

        // List of states for URLs
        $stateList = array(
            '2'  => State::NAME_ARC,
            '3'  => State::NAME_VINNYTSIA,
            '4'  => State::NAME_VOLYN,
            '5'  => State::NAME_DNIPROPETROVSK,
            '6'  => State::NAME_DONETSK,
            '7'  => State::NAME_ZHYTOMYR,
            '8'  => State::NAME_ZAKARPATTIA,
            '9'  => State::NAME_ZAPORIZHIA,
            '10' => State::NAME_IVANO_FRANKIVSK,
            '11' => State::NAME_KIEV,
            '12' => State::NAME_KIROVOHRAD,
            '13' => State::NAME_LUHANSK,
            '14' => State::NAME_LVIV,
            '15' => State::NAME_MYKOLAIV,
            '16' => State::NAME_ODESSA,
            '17' => State::NAME_POLTAVA,
            '18' => State::NAME_RIVNE,
            '19' => State::NAME_SUMY,
            '20' => State::NAME_TERNOPIL,
            '21' => State::NAME_KHARKIV,
            '22' => State::NAME_KHERSON,
            '23' => State::NAME_KHMELNYTSKYI,
            '24' => State::NAME_CHERKASY,
            '25' => State::NAME_CHERNIVTSI,
            '26' => State::NAME_CHERNIHIV,
            '27' => State::NAME_KIEV,
            '28' => State::NAME_ARC,
        );

        // Parse each state
        foreach ($stateList as $num => $stateName) {
            $parser = new \Sunra\PhpSimple\HtmlDomParser();
            $html = $parser->file_get_html('http://www.vstup.info/' . $year . '/i' . $year . 'o' . $num . '.html');
            foreach ($html->find('#branch2 a') as $u) {
                $text = $u->plaintext;
                // Check for forbidden words
                if ($this->_hasForbiddenWords($text)) {
                    continue;
                }
                // Check if it has needed words
                if (!$this->_hasNeededWord($text)) {
                    continue;
                }
                $school = new School();
                $school->setAttributes(array(
                    'fullNameUk'    => $text,
                    'state'         => $stateName,
                    'region'        => State::get($stateName)->region->name,
                ), false);
                $school->save();
                echo ".";
            }
            unset($html);
        }
        echo "\nSUCCESS! Parsed and saved.";
    }

}