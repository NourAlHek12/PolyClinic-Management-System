<?php 
class Appointment {
    public $id;
    public $doctor;
    public $patient; // as an object
    public $start; // as an object
    public $end;
    public $status;
    public $fees; //  may be null
    public $secretary;// as an object \\ may be a null
    public $createdAt;

    public function __construct($id, $doctor, $patient, $start, $end, $status, $fees, $secretary, $createdAt) {
        $this->id = $id;
        $this->doctor = $doctor;
        $this->patient = $patient;
        $this->start = $start;
        $this->end = $end;
        $this->status = $status;
        $this->fees = $fees;
        $this->secretary = $secretary;
        $this->createdAt = $createdAt;
    }

    // You can add more methods here as needed
}
