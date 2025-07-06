<?php
class Manager {
    public $id;
    public $password;

    public function __construct($id, $password) {
        $this->id = $id;
        $this->password = $password;
    }

    // You can add more methods here as needed
}
