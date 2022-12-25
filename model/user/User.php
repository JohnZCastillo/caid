<?php

namespace model\user;

// Note the default role of a user is student
class User
{

    private $id;
    private $role;
    private $username;
    private $password;
    private $email;
    private $fName;
    private $mName;
    private $lName;
    private $gender;
    private $course;
    private $year;
    private $birthdate;
    private $profileLink;

    public function __construct($id, $username, $password, $email, $fName, $mName, $lName, $gender, $course, $year, $birthdate)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->fName = $fName;
        $this->mName = $mName;
        $this->lName = $lName;
        $this->gender = $gender;
        $this->course = $course;
        $this->year = $year;
        $this->birthdate = $birthdate;
        $this->role = Role::$STUDENT;
    }

    public function setProfile($link)
    {
        $this->profileLink = $link;
    }

    public function getProfile()
    {
        return $this->profileLink;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getFullName()
    {
        return $this->getFName() . " " . $this->getMName() . " " . $this->getLName();
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFName()
    {
        return $this->fName;
    }

    public function getMName()
    {
        return $this->mName;
    }

    public function getLName()
    {
        return $this->lName;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setRole($role): void
    {
        $this->role = $role;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setFName($fName): void
    {
        $this->fName = $fName;
    }

    public function setMName($mName): void
    {
        $this->mName = $mName;
    }

    public function setLName($lName): void
    {
        $this->lName = $lName;
    }

    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    public function setCourse($course): void
    {
        $this->course = $course;
    }

    public function setYear($year): void
    {
        $this->year = $year;
    }

    public function setBirthdate($birthdate): void
    {
        $this->birthdate = $birthdate;
    }
}
