<?php

namespace console\helpers;

class Db
{

    /**
     * Returns DSN attribute
     * @param string $dsn
     * @param string $attribute
     * @param string $default
     * @return string
     */
    public static function getDsnAttribute($dsn, $attribute, $default = null)
    {
        if (preg_match('/' . $attribute . '=([^;]*)/', $dsn, $match)) {
            $value = $match[1];
        } else {
            $value = $default;
        }
        return $value;
    }

}
