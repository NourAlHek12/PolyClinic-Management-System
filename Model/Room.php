<?php
class Room{
    public $id;
    public $number;
    public $desc;
    function __construct($id, $number,$desc){
        $this->id = $id;
        $this->number = $number;
        $this->desc = $desc;
    }
}