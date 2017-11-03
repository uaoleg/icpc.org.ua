<?php

namespace common\models\User;

use \common\models\BaseActiveRecord;

/**
 * User info
 *
 * @property int    $userId
 * @property string $lang
 * @property string $dateOfBirth
 * @property string $phoneHome
 * @property string $phoneMobile
 * @property string $skype
 * @property string $tShirtSize
 * @property string $acmNumber
 */
abstract class Info extends BaseActiveRecord
{

    /**
     * Scenarios
     */
    const SC_ALLOW_EMPTY = 'allowEmpty';

    /**
     * Returns the attribute labels.
     * @return array attribute labels (name => label)
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), array(
            'userId'        => \yii::t('app', 'Related user ID'),
            'lang'          => \yii::t('app', 'Language of the information'),
            'dateOfBirth'   => \yii::t('app', 'Date of birth'),
            'phoneHome'     => \yii::t('app', 'Home phone number'),
            'phoneMobile'   => \yii::t('app', 'Mobile phone number'),
            'skype'         => \yii::t('app', 'Skype'),
            'tShirtSize'    => \yii::t('app', 'T-shirt size'),
            'acmNumber'     => \yii::t('app', 'ACM number'),
        ));
    }

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorDateFormat(['dateOfBirth']),
        ];
    }

    /**
     * Define attribute rules
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['lang', 'dateOfBirth', 'userId', 'tShirtSize'], 'required', 'except' => static::SC_ALLOW_EMPTY],
            ['tShirtSize', 'in', 'range' => array('XS', 'S', 'M', 'L', 'XL', 'XXL')],
            [['phoneHome', 'phoneMobile'], Info\Validator\Phone::class, 'except' => static::SC_ALLOW_EMPTY],
        ]);
    }

    /**
     * Before save action
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // Convert empty attributes to NULL
        foreach ($this->attributes as $name => $value) {
            if (empty($this->$name)) {
                $this->$name = null;
            }
        }

        return true;
    }

    /**
     * After save action
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        // Copy new contacts to the other languages
        if (false
            || $this->isAttributeChangedAfterSave('skype', $changedAttributes)
            || $this->isAttributeChangedAfterSave('phoneHome', $changedAttributes)
            || $this->isAttributeChangedAfterSave('phoneMobile', $changedAttributes)
            || $this->isAttributeChangedAfterSave('acmNumber', $changedAttributes)
            || $this->isAttributeChangedAfterSave('tShirtSize', $changedAttributes)
            || $this->isAttributeChangedAfterSave('dateOfBirth', $changedAttributes)
        ) {
            static::updateAll([
                'skype'         => $this->skype,
                'phoneHome'     => $this->phoneHome,
                'phoneMobile'   => $this->phoneMobile,
                'tShirtSize'    => $this->tShirtSize,
                'acmNumber'     => $this->acmNumber,
                'dateOfBirth'   => $this->dateOfBirth,
            ], 'lang != :lang', [':lang' => $this->lang]);
        }

        parent::afterSave($insert, $changedAttributes);
    }


}
