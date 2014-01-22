<?php

namespace common\ext\MongoDb;

abstract class Validator extends \CValidator
{

    /**
     * Returns class name
     *
     * @return string
     */
    public static function className()
    {
        return get_called_class();
    }

}