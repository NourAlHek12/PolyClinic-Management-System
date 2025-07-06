<?php
class weekSchedule{
    public $id;
    public $doctor; // as an object
    public $day;
    public $shift; //
    public $start;
    public $end;
    public $room;
    public function __construct($id, $doctor,$day,$shift, $start,$end,$room){
        $this->id = $id;
        $this->day = $day;
        $this->shift = $shift;
        $this->doctor = $doctor;
        $this->start = $start;
        $this->end = $end;
        $this->room = $room;
    }
    public function getDoctor(){
        return $this->doctor;
    }

}