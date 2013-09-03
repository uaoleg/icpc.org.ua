<?php

namespace common\ext\MongoDb;

abstract class EmbeddedDocument extends \EMongoEmbeddedDocument
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