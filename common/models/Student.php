<?php
namespace common\models;


class Student extends Person {

    public function getCollectionName() {
        return 'student';
    }

    public $speciality;
    public $group;
    public $course;
    public $phone;

    public $dateOfBirth;
    public $isApprovedStudent;

    public $schoolFullNameUk;
    public $schoolFullNameEn;
}