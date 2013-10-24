<?php

namespace common\models\Geo;

/**
 * Region
 */
class Region extends \common\ext\MongoDb\Document
{

    /**
     * Available regions
     */
    const NAME_CENTER   = 'center';
    const NAME_EAST     = 'east';
    const NAME_KIEV     = 'kiev';
    const NAME_SOUTH    = 'south';
    const NAME_WEST     = 'west';

    /**
     * Region name
     * @var string
     */
    public $name;

    /**
     * Returns an instance of region
     *
     * @param string $name
     * @return Region
     * @throws \CException
     */
    public static function get($name)
    {
        if (in_array($name, static::model()->getConstantList('NAME_'))) {
            $region = new static();
            $region->name = $name;
            return $region;
        } else {
            throw new \CException(\yii::t('app', 'Unknown region name.'));
        }
    }

    /**
     * Returns region name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
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
            'name' => \yii::t('app', 'Region name'),
            'const.name' => array(
                static::NAME_CENTER => \yii::t('app', 'Center'),
                static::NAME_EAST   => \yii::t('app', 'East'),
                static::NAME_KIEV   => \yii::t('app', 'Kiev'),
                static::NAME_SOUTH  => \yii::t('app', 'South'),
                static::NAME_WEST   => \yii::t('app', 'West'),
            ),
        ));
    }

	/**
	 * This returns the name of the collection for this class
     *
     * @return string
	 */
	public function getCollectionName()
	{
		return 'geo.region';
	}

}