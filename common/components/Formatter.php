<?php

namespace common\components;

use \common\models\Firm;
use \common\models\Currency;
use \common\models\Location;

/**
 * @link http://userguide.icu-project.org/formatparse/datetime
 */
class Formatter extends \yii\i18n\Formatter
{

    /**
     * Formats the value as a date
     * If provided value is not a valid date, than returns safe value, no exception is thrown
     * @param string $value
     * @param string $safeValue
     * @param string $format
     * @return string
     */
    public function asDateSafe($value, $safeValue = null, $format = null)
    {
        // Set NULL display to empty value
        $nullDisplay = $this->nullDisplay;
        $this->nullDisplay = $safeValue;

        // Format date
        try {
            $date = parent::asDate($value, $format);
        } catch (\Exception $ex) {
            $date = ($safeValue !== null) ? $safeValue : $value;
        }

        // Returns back NULL display value
        $this->nullDisplay = $nullDisplay;

        return $date;
    }

    /**
     * Format phone number
     * @param string $phoneNumber
     * @param string $countryIso2
     * @return string
     */
    public function asPhoneNumber($phoneNumber, $countryIso2 = null)
    {
        $util = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $phone = $util->parse($phoneNumber, $countryIso2);
            $result = $util->format($phone, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
        } catch (\libphonenumber\NumberParseException $e) {
            $result = $phoneNumber;
        }
        return $result;
    }

    /**
     * Formats given value as price
     * @param mixed $value
     * @param bool  $withPennies
     * @return string
     */
    public function asPrice($value, $withPennies = true)
    {
        $value = round($value * 100) / 100;
        return number_format($value, $withPennies ? 2 : 0, ',', ' ');
    }

    /**
     * Formats given value as price with it's currency label
     * @param mixed     $value
     * @param string    $currency
     * @return string
     */
    public function asPriceWithCurrency($value, $currency = null)
    {
        if (!$currency) {
            $currency = Firm::defaultCurrency();
        }
        return $this->asPrice($value) . ' ' . Currency::getLabelAlt($currency);
    }

    /**
     * @link http://intl.rmcreative.ru/site/message-formatting?locale=uk_UA
     * @param int $value
     * @return string
     */
    public function asPriceSpellout($value)
    {
        switch ($this->locale) {
            case 'uk-UA':
                $result = '';
                $number = (int)(($value % 1000) / 1);
                if ($number > 0 || !$value) {
                    $result = \yii::t('app', '{0, spellout,%spellout-cardinal-feminine}', $number) . ' ' . $result;
                }
                $number = (int)(($value % 1000000) / 1000);
                if ($number > 0 && $value >= 1000) {
                    $result = \yii::t('app', '{0, spellout,%spellout-cardinal-feminine} {0, plural, one{тисяча} few{тисячі} many{тисяч} other{тисячі}}', $number) . ' ' . $result;
                }
                $number = (int)(($value % 1000000000) / 1000000);
                if ($number > 0 && $value >= 1000000) {
                    $result = \yii::t('app', '{0, spellout,%spellout-cardinal-masculine} {0, plural, one{мільйон} few{мільйони} many{мільйонів} other{мільйони}}', $number) . ' ' . $result;
                }
                break;
            default:
                $result = $this->asSpellout($value);
                break;
        }
        return trim($result);
    }

    /**
     * Returns only pennies of the price
     * @param float $value
     * @return string
     */
    public function asPricePenniesOnly($value)
    {
        $pennies = (string)($value * 100 - ((int)$value * 100));
        if (mb_strlen($pennies) === 1) {
            $pennies = '0' . $pennies;
        }
        return $pennies;
    }

    /**
     * Parse price from given string
     * @link https://stackoverflow.com/a/19764699/676479
     * @param string $value
     * @return float
     */
    public function parsePrice($value)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $value);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $value);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousendSeparator);
    }

    /**
     * Parse currency from given string
     * @param string $value
     * @return string
     */
    public function parseCurrency($value)
    {
        $currency = null;
        $value = mb_strtolower($value);
        if (preg_match('/eur|€|euro|евро|євро/', $value)) {
            $currency = Currency::EUR;
        } elseif (preg_match('/mdl|leu|lei|лей/', $value)) {
            $currency = Currency::MDL;
        } elseif (preg_match('/uah|₴|грн|гр/', $value)) {
            $currency = Currency::UAH;
        } elseif (preg_match('/usd|$|дол/', $value)) {
            $currency = Currency::USD;
        }
        return $currency;
    }

    /**
     * Returns format settings for phone input mask
     * @return array
     */
    public function phoneFormatInputMask()
    {
        $formats = \yii::$app->params['phoneFormat.inputMask'];
        if (Firm::countryIso2()) {
            $format = $formats[Firm::countryIso2()];
        } else {
            $format = $formats[Location\Country::DEFAULT_COUNTRY_ISO2];
        }
        return $format;
    }

}
