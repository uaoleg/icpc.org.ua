<?php

namespace common\models;

/**
 * Person (student or coach)
 *
 * @property string $firstNameUk
 * @property string $middleNameUk
 * @property string $lastNameUk
 * @property string $firstNameEn
 * @property string $middleNameEn
 * @property string $lastNameEn
 * @property string $email
 * @property int    $timeCreated
 * @property int    $timeUpdated
 */
abstract class Person extends BaseActiveRecord
{

    /**
     * Returns a list of behaviors that this component should behave as
     * @return array
     */
    public function behaviors()
    {
        return [
            $this->behaviorTimestamp(),
        ];
    }

    /**
     * Returns first name in appropriate language
     *
     * @return string
     */
    public function getFirstName()
    {
        switch (static::$useLanguage) {
            default:
            case 'uk':
                return $this->firstNameUk;
            case 'en':
                return $this->firstNameEn;
        }
    }

    /**
     * Returns middle name in appropriate language
     *
     * @return string
     */
    public function getMiddleName()
    {
        switch (static::$useLanguage) {
            default:
            case 'uk':
                return $this->middleNameUk;
            case 'en':
                return $this->middleNameEn;
        }
    }

    /**
     * Returns last name in appropriate language
     *
     * @return string
     */
    public function getLastName()
    {
        switch (static::$useLanguage) {
            default:
            case 'uk':
                return $this->lastNameUk;
            case 'en':
                return $this->lastNameEn;
        }
    }

}
