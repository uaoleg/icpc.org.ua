<?php

use common\models\Geo\State;

class SchoolCommand extends \console\ext\ConsoleCommand
{

    /**
     * list of states for urls
     * @var array
     */
    private $_states = array(
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

    /**
     * list of words. Any of these should be present in the name of university
     * @var array
     */
    private $_words = array('університет', 'академія', 'інститут');

    /**
     * If a university has any of these words in its name we don't save it
     * @var array
     */
    private $_forbidden_words = array('коледж', 'училище', 'технікум');

    /**
     * method which parses all the pages
     * @param null $year
     * @return int
     */
    public function actionParse($year = NULL) {
        if (!isset($year)) {
            $year = date('Y');
        }
        $year = (int)$year;
        \yii::import('common.lib.HtmlDomParser.*');
        require_once('HtmlDomParser.php');

        if (!empty($year)) {
            foreach ($this->_states as $num=>$name) {
                $parser = new \Sunra\PhpSimple\HtmlDomParser();
                $parser = $parser->file_get_html('http://www.vstup.info/' . $year . '/i' . $year . 'o' . $num . '.html');
                foreach ($parser->find('#branch2 a') as $u) {
                    $text = $u->plaintext;

//                    check for forbidden words
                    if ($this->_hasForbiddenWords($text)) {
                        continue;
                    }

//                    check if it has needed words
                    if ($this->_hasNeededWord($text)) {

                        $school = new \common\models\School();
                        $school->fullNameUa = $text;
                        $school->state = $name;
                        $school->region = State::get($name)->region->name;
                        $school->save();
                    }
                }
                unset($parser);
            }
            echo \yii::t('app', 'SUCCESS! Parsed and saved.');
            return 0;
        } else {
            echo \yii::t('app', 'ERROR! Year is invalid.');
            return 1;
        }

    }

    /**
     * checks if a name contains any of forbidden words
     * @param $text
     * @return bool
     */
    private function _hasForbiddenWords($text) {
        $fwords = $this->_forbidden_words;
        foreach ($fwords as $fword) {
            if (mb_stripos($text, $fword, null, "UTF-8") !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * checks if a name contains any of needed words
     * @param $text
     * @return bool
     */
    private function _hasNeededWord($text) {
        $nwords = $this->_words;
        foreach ($nwords as $nword) {
            if (mb_stripos($text, $nword, null, "UTF-8") !== false) {
                return true;
            }
        }
        return false;
    }

}