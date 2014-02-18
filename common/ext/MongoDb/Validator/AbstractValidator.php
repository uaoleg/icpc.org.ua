<?php

namespace common\ext\MongoDb\Validator;

abstract class AbstractValidator extends \CValidator
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