<?php

namespace yii\helpers;

/**
 * StringHelper
 */
class StringHelper extends BaseStringHelper
{

    /**
     * Returns given string with first character uppercased
     * @param string $string
     * @param string $encoding
     * @return string
     */
    public static function ucfirst($string, $encoding = null)
    {
        if (!$encoding) {
            $encoding = \mb_internal_encoding();
        }
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    /**
     * Returns given string prepared for DB search using REGEXP
     * @param string $string
     * @return string
     */
    public static function dbFindRegexp($string)
    {
        return str_replace(' ', '|', mb_strtolower(preg_quote($string)));
    }

    /**
     * Remove 4 bytes characters from the string
     * @link https://stackoverflow.com/questions/10957238/incorrect-string-value-when-trying-to-insert-utf-8-into-mysql-via-jdbc
     * @link https://stackoverflow.com/questions/8491431/how-to-replace-remove-4-byte-characters-from-a-utf-8-string-in-php
     * @param string $string
     * @return string
     */
    public static function filterUtf8Bytes4($string)
    {
        return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $string);
    }

    /**
     * Replace placeholders in the string with the given params
     * @param string $string
     * @param array $params
     * @return string
     */
    public static function replacePlaceholders($string, array $params, $left = '{', $right = '}')
    {
        $placeholders = [];
        foreach ((array) $params as $name => $value) {
            $placeholders[$left . $name . $right] = $value;
        }

        return ($placeholders === []) ? $string : strtr($string, $placeholders);
    }

}
