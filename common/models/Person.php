<?php
/**
 * Created by PhpStorm.
 * User: egor.litvinov
 * Date: 25.03.2015
 * Time: 16:25
 */

namespace common\models;


abstract class Person extends \common\ext\MongoDb\Document {

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
                break;
            case 'en':
                return (!empty($this->firstNameEn)) ? $this->firstNameEn : $this->firstNameUk;
                break;
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
                break;
            case 'en':
                return (!empty($this->middleNameEn)) ? $this->middleNameEn : $this->middleNameUk;
                break;
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
                break;
            case 'en':
                return (!empty($this->lastNameEn)) ? $this->lastNameEn : $this->lastNameUk;
                break;
        }
    }
}