<?php
class Consultation {
    public $id;
    public $appointment;

    public $notes;
    public $allergy;
    public $previousTreatment;
    public $laboratoryResult;
    public $currentTreatment;

    public function __construct($id, $appointment, $notes, $allergy, $previousTreatment, $laboratoryResult, $currentTreatment) {
        $this->id = $id;
        $this->appointment = $appointment;
        $this->notes = $notes;
        $this->allergy = $allergy;
        $this->previousTreatment = $previousTreatment;
        $this->laboratoryResult = $laboratoryResult;
        $this->currentTreatment = $currentTreatment;
    }

    // You can add more methods here as needed
}
