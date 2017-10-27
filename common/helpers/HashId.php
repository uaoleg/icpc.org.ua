<?php

namespace common\helpers;

/**
 * Hash ID for AR models
 */
class HashId
{

    const HASH_ID_LENGTH = 10;

    /**
     * Generate numeric hash ID
     * @param type $sid
     * @return string
     */
    public static function generate($sid = '')
    {
        if (empty($sid)) {
            $sid = date('zy'); // The day of the year + year
        }
        $hash = (string)$sid;
        $prepend = true;
        while (mb_strlen($hash) < static::HASH_ID_LENGTH) {
            $rand = (string)rand(0, 9);
            if ($prepend) {
                $hash = $rand . $hash;
            } else {
                $hash = $hash . $rand;
            }
            $prepend = !$prepend;
        }
        return $hash;
    }

}
