<?php

namespace common\models;

abstract class Person extends \common\ext\MongoDb\Document
{

    /**
     * First name in Ukrainian
     * @var string
     */
    public $firstNameUk;

    /**
     * Middle name in Ukrainian
     * @var string
     */
    public $middleNameUk;

    /**
     * Last name in Ukrainian
     * @var string
     */
    public $lastNameUk;

    /**
     * First name in English
     * @var string
     */
    public $firstNameEn;

    /**
     * Middle name in English
     * @var string
     */
    public $middleNameEn;

    /**
     * Last name in English
     * @var string
     */
    public $lastNameEn;

    /**
     * Contact email
     * @var string
     */
    public $email;

    /**
     * Date created
     * @var int
     */
    public $dateCreated;

    /**
     * Returns first name in appropriate language
     *
     * @return string
     */
    public function getFirstName()
    {
        switch ($this->useLanguage) {
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
        switch ($this->useLanguage) {
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
        switch ($this->useLanguage) {
            default:
            case 'uk':
                return $this->lastNameUk;
            case 'en':
                return $this->lastNameEn;
        }
    }

}
