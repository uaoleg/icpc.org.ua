<?php

namespace common\models\Geo;

use \common\models\BaseActiveRecord;

/**
 * Region
 *
 * @property string $name
 */
class Region extends BaseActiveRecord
{

    /**
     * Available regions
     */
    const NAME_CENTER       = 'center';
    const NAME_NORTH        = 'north';
    const NAME_EAST         = 'east';
    const NAME_SOUTH        = 'south';
    const NAME_WEST         = 'west';
    const NAME_SOUTH_WEST   = 'south_west';

    /**
     * Declares the name of the database table associated with this AR class
     * @return string
     */
    public static function tableName()
    {
        return '{{%geo_region}}';
    }

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'name' => \yii::t('app', 'Region name'),
            'const.name' => array(
                static::NAME_CENTER     => \yii::t('app', 'Center'),
                static::NAME_NORTH      => \yii::t('app', 'North'),
                static::NAME_EAST       => \yii::t('app', 'East'),
                static::NAME_SOUTH      => \yii::t('app', 'South'),
                static::NAME_WEST       => \yii::t('app', 'West'),
                static::NAME_SOUTH_WEST => \yii::t('app', 'Southwestern'),
            ),
        ));
    }

    /**
     * Returns the constant labels
     * @return string[]
     */
    public static function constantLabels()
    {
        return [
            static::NAME_CENTER     => \yii::t('app', 'Center'),
            static::NAME_NORTH      => \yii::t('app', 'North'),
            static::NAME_EAST       => \yii::t('app', 'East'),
            static::NAME_SOUTH      => \yii::t('app', 'South'),
            static::NAME_WEST       => \yii::t('app', 'West'),
            static::NAME_SOUTH_WEST => \yii::t('app', 'Southwestern'),
        ];
    }

    /**
     * Returns an instance of region
     *
     * @param string $name
     * @return Region
     * @throws \yii\base\Exception
     */
    public static function get($name)
    {
        if (in_array($name, static::getConstants('NAME_'))) {
            $region = new static();
            $region->name = $name;
            return $region;
        } else {
            throw new \yii\base\Exception(\yii::t('app', 'Unknown region name.'));
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

}
