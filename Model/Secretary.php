<?php
class Secretary {
    public $id;
    public $name;
    public $phone;
    public $password;

    public function __construct($id,$name,  $phone, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->password = $password;
    }

    // You can add more methods here as needed
}
