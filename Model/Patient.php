<?php
class Patient {
    public $id;
    public $firstName;
    public $lastName;
    public $gmail;
    public $password;
    public $phone;

    public function __construct($id, $firstName, $lastName, $gmail, $password, $phone) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gmail = $gmail;
        $this->password = $password;
        $this->phone = $phone;
    }

    // You can add more methods here as needed
}
