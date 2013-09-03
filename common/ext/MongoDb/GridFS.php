<?php

namespace common\ext\MongoDb;

abstract class GridFS extends \EMongoGridFS
{

    /**
     * This field is optional, but:
     * from PHP MongoDB driver manual:
     *
     * 'You should be able to use any files created by MongoGridFS with any other drivers, and vice versa.
     * However, some drivers expect that all metadata associated with a file be in a "metadata" field.
     * If you're going to be using other languages, it's a good idea to wrap info you might want them
     * to see in a "metadata" field.'
     *
     * @var array $metadata array of additional info/metadata about a file
     */
    public $metadata = array();

    /**
     * Returns the model of called class
     *
     * @param string $className EMongoDocument class name
     * @return \EMongoGridFS model instance
     */
    public static function model($className = null)
    {
        if ($className === null) {
            $className = get_called_class();
        }
        return parent::model($className);
    }

    /**
     * Returns the attribute labels.
     *
     * Note, in order to inherit labels defined in the parent class, a child class needs to
     * merge the parent labels with child labels using functions like array_merge().
     *
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'metadata' => \yii::t('app', 'Metadata'),
        ));
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), array(
            array('filename', 'required'),
        ));
    }

    /**
     * List of collection indexes
     *
     * @return array
     */
    public function indexes()
    {
        return array_merge(parent::indexes(), array(
            'filename' => array(
                'key' => array(
                    'filename' => \EMongoCriteria::SORT_ASC,
                ),
            ),
        ));
    }

}