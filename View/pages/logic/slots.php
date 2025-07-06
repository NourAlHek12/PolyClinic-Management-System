<?php
function getSlots($array) {
    $slots = array();

    // Check if 'before' shift exists
    if (isset($array['before'])) {
        $beforeStart = strtotime($array['before'][0]);
        $beforeEnd = strtotime($array['before'][1]);

        // Generate slots for 'before'
        $currentSlot = $beforeStart;
        while ($currentSlot < $beforeEnd) {
            $slots[] = date('H:i:s', $currentSlot);
            $currentSlot = strtotime('+30 minutes', $currentSlot);
        }
    }

    // Check if 'after' shift exists
    if (isset($array['after'])) {
        $afterStart = strtotime($array['after'][0]);
        $afterEnd = strtotime($array['after'][1]);

        // Generate slots for 'after'
        $currentSlot = $afterStart;
        while ($currentSlot < $afterEnd) {
            $slots[] = date('H:i:s', $currentSlot);
            $currentSlot = strtotime('+30 minutes', $currentSlot);
        }
    }

    return $slots;
}
function getTimeFromDate($dateTimeString) {
    // Convert the date-time string to a timestamp
    $timestamp = strtotime($dateTimeString);
    
    // Extract the time from the timestamp
    $time = date('H:i:s', $timestamp);
    
    return $time;
}

function removeUnavailableSlots($generalSlots, $appointments){
    $availableSlots = $generalSlots;

    foreach ($appointments as $appointment) {
        $start = strtotime(getTimeFromDate($appointment->start));
        $end = strtotime(getTimeFromDate($appointment->end));
        // Remove slots within the appointment's time range
        foreach ($availableSlots as $key => $slot) {

            $slotTime = strtotime($slot);
            if ($slotTime >= $start && $slotTime < $end) {
                unset($availableSlots[$key]);
            }
        }
    }

    return array_values($availableSlots); // Reset array keys
}




/*
$input = array(
    'before' => array('08:00:00', '10:00:00'),
    'after' => array('15:30:00', '18:00:00')
);
$slots = getSlots($input);
print_r($slots);
*/


