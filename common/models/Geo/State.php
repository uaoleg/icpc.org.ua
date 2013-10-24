<?php

namespace common\models\Geo;

/**
 * State
 *
 * @property string $region Name of the related region
 */
class State extends \common\ext\MongoDb\Document
{

    /**
     * Available states
     */
    const NAME_ARC              = 'arc';
    const NAME_CHERKASY         = 'cherkasy';
    const NAME_CHERNIHIV        = 'chernihiv';
    const NAME_CHERNIVTSI       = 'chernivtsi';
    const NAME_DNIPROPETROVSK   = 'dnipropetrovsk';
    const NAME_DONETSK          = 'donetsk';
    const NAME_IVANO_FRANKIVSK  = 'ivano-frankivsk';
    const NAME_KHARKIV          = 'kharkiv';
    const NAME_KHERSON          = 'kherson';
    const NAME_KHMELNYTSKYI     = 'khmelnytskyi';
    const NAME_KIEV             = 'kiev';
    const NAME_KIROVOHRAD       = 'kirovohrad';
    const NAME_LUHANSK          = 'luhansk';
    const NAME_LVIV             = 'lviv';
    const NAME_MYKOLAIV         = 'mykolaiv';
    const NAME_ODESSA           = 'odessa';
    const NAME_POLTAVA          = 'poltava';
    const NAME_RIVNE            = 'rivne';
    const NAME_SUMY             = 'sumy';
    const NAME_TERNOPIL         = 'ternopil';
    const NAME_VINNYTSIA        = 'vinnytsia';
    const NAME_VOLYN            = 'volyn';
    const NAME_ZAKARPATTIA      = 'zakarpattia';
    const NAME_ZAPORIZHIA       = 'zaporizhia';
    const NAME_ZHYTOMYR         = 'zhytomyr';

    /**
     * State name
     * @var string
     */
    public $name;

    /**
     * Name of the related region
     * @var string
     */
    protected $_region;

    /**
     * Returns an instance of state
     *
     * @param string $name
     * @return State
     * @throws \CException
     */
    public static function get($name)
    {
        if (in_array($name, static::model()->getConstantList('NAME_'))) {
            $state = new static();
            $state->name = $name;
            return $state;
        } else {
            throw new \CException(\yii::t('app', 'Unknown state name.'));
        }
    }

    /**
     * Returns state name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Returns the related region
     *
     * @return Region
     */
    public function getRegion()
    {
        if ($this->_region === null) {
            switch ($this->name) {
                case static::NAME_CHERKASY:
                case static::NAME_CHERNIHIV:
                case static::NAME_DNIPROPETROVSK:
                case static::NAME_KIROVOHRAD:
                case static::NAME_POLTAVA:
                case static::NAME_SUMY:
                case static::NAME_VINNYTSIA:
                case static::NAME_ZHYTOMYR:
                    $this->_region = Region::get(Region::NAME_CENTER);
                    break;
                case static::NAME_DONETSK:
                case static::NAME_KHARKIV:
                case static::NAME_LUHANSK:
                    $this->_region = Region::get(Region::NAME_EAST);
                    break;
                case static::NAME_KIEV:
                    $this->_region = Region::get(Region::NAME_KIEV);
                    break;
                case static::NAME_ARC:
                case static::NAME_KHERSON:
                case static::NAME_MYKOLAIV:
                case static::NAME_ODESSA:
                case static::NAME_ZAPORIZHIA:
                    $this->_region = Region::get(Region::NAME_SOUTH);
                    break;
                case static::NAME_IVANO_FRANKIVSK:
                case static::NAME_VOLYN:
                case static::NAME_LVIV:
                case static::NAME_RIVNE:
                case static::NAME_TERNOPIL:
                case static::NAME_ZAKARPATTIA:
                case static::NAME_KHMELNYTSKYI:
                case static::NAME_CHERNIVTSI:
                    $this->_region = Region::get(Region::NAME_WEST);
                    break;
            }
        }
        return $this->_region;
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
            'name' => \yii::t('app', 'State name'),
            'const.name' => array(
                static::NAME_ARC             => \yii::t('app', 'ARC'),
                static::NAME_CHERKASY        => \yii::t('app', 'Cherkasy'),
                static::NAME_CHERNIHIV       => \yii::t('app', 'Chernihiv'),
                static::NAME_CHERNIVTSI      => \yii::t('app', 'Chernivtsi'),
                static::NAME_DNIPROPETROVSK  => \yii::t('app', 'Dnipropetrovsk'),
                static::NAME_DONETSK         => \yii::t('app', 'Donetsk'),
                static::NAME_IVANO_FRANKIVSK => \yii::t('app', 'Ivano-Frankivsk'),
                static::NAME_KHARKIV         => \yii::t('app', 'Kharkiv'),
                static::NAME_KHERSON         => \yii::t('app', 'Kherson'),
                static::NAME_KHMELNYTSKYI    => \yii::t('app', 'Khmelnytskyi'),
                static::NAME_KIEV            => \yii::t('app', 'Kiev'),
                static::NAME_KIROVOHRAD      => \yii::t('app', 'Kirovohrad'),
                static::NAME_LUHANSK         => \yii::t('app', 'Luhansk'),
                static::NAME_LVIV            => \yii::t('app', 'Lviv'),
                static::NAME_MYKOLAIV        => \yii::t('app', 'Mykolaiv'),
                static::NAME_ODESSA          => \yii::t('app', 'Odessa'),
                static::NAME_POLTAVA         => \yii::t('app', 'Poltava'),
                static::NAME_RIVNE           => \yii::t('app', 'Rivne'),
                static::NAME_SUMY            => \yii::t('app', 'Sumy'),
                static::NAME_TERNOPIL        => \yii::t('app', 'Ternopil'),
                static::NAME_VINNYTSIA       => \yii::t('app', 'Vinnytsia'),
                static::NAME_VOLYN           => \yii::t('app', 'Volyn'),
                static::NAME_ZAKARPATTIA     => \yii::t('app', 'Zakarpattia'),
                static::NAME_ZAPORIZHIA      => \yii::t('app', 'Zaporizhia'),
                static::NAME_ZHYTOMYR        => \yii::t('app', 'Zhytomyr'),
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
		return 'geo.state';
	}

}