<?php 
class Doctor {
    public $id;
    public $firstName;
    public $lastName;
    public $gmail;
    public $password;
    public $picture;
    public $phone;
    public $speciality;

    public function __construct($id, $firstName, $lastName, $gmail, $password, $picture, $phone, $speciality) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gmail = $gmail;
        $this->password = $password;
        $this->picture = $picture;
        $this->phone = $phone;
        $this->speciality = $speciality;
    }

    // You can add more methods here as needed
}
