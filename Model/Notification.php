<?php
class Notification {
    public $id;
    public $appointment;
    public $content;
    public $createdAt;

    public function __construct($id, $appointment, $content, $createdAt) {
        $this->id = $id;
        $this->appointment = $appointment;
        $this->content = $content;
        $this->createdAt = $createdAt;
    }

    // You can add more methods here as needed
}
