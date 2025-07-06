<?php include '../../utils/autoLoad.php'; ?>
<?php include '../../utils/connectToDb.php'; ?>
<?php include '../../Controller/weekScheduleController.php'; ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>doctors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="shortcut icon" href="../images/icons8-clinic-16.png" type="image/icon">
</head>
<?php include '../components/header.php';?>
<?php
if(!isset($_GET['doctorId'])){
    header("LOCATION:home.php");
}
$id = $_GET['doctorId'];
?>
<?php
if(isset($_GET['day'])){
    $daySelected = $_GET['day'];
    if (!strtotime($daySelected)) {
        // Redirect to schedule.php
        header("Location: schedule.php?doctorId=$id");
        exit; // Make sure to exit after redirection
    }
    include '../../Controller/appointmentController.php';
    $apps = getDoctorAppointmentByDate($daySelected,$id);
}
?>

<body>
    <br>
    <br>
    <br>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
            <?php
            include '../../Controller/doctorController.php';
            $doctor = getDoctorById($_GET['doctorId']);
            ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Doctor Information</h5>
                        <p class="card-text">Name: <?=$doctor->firstName." ".$doctor->lastName?></p>
                        <p class="card-text">Gmail: <?=$doctor->gmail;?></p>
                        <p class="card-text">Phone: <?=$doctor->phone;?></p>
                        <p class="card-text" style="color:chocolate">Specialty: <?=$doctor->speciality->name;?></p>
                    </div>
                </div>

                <!-- Include Doctor Info here -->
            </div>
            <div class="col-md-6">
                <!-- Schedule Form -->
                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-info">
                        <?=$_SESSION['message'];?>
                    </div>
                <?php unset($_SESSION['message']); endif; ?>
                <?php  if(isset($_GET['day'])): ?>
                <h2>Book an Appointment</h2>
                <form id="parent" action="../../post/appointment.php" method="post">
                    <p>Selected Day : <b style="color:red"><?= date("l", strtotime($_GET['day']))?></b></p>
                    <!-- Parent form fields here -->
                    <?php if(isset($daySelected)):?>
                        <input type="date" name="day" id="daySelected" class="form-control" required value="<?=$daySelected?>" onchange="c()">
                    <?php else : ?>
                        <input type="date" name="day" id="" required class="form-control">
                    <?php endif;?>
                    <input type="hidden" name="doctorId" value="<?=$_GET['doctorId'];?>">
                    <?php
                    $_slots = getScheduleByDay($_GET['doctorId'] ,strtolower(date("l", strtotime($_GET['day']))) ) ;
                    //echo count($_slots);
                    ?>
                    <?php 
                    if(empty($_slots)):
                    ?>
                    <div class="mt-1 mb-1 p-2">
                        <div class="alert alert-danger">Dr. <?=$doctor->firstName." ".$doctor->lastName?> is off in <?=strtolower(date("l", strtotime($_GET['day'])))?></div>
                    </div>
                    <?php else: ?>
                        <?php                    
                         if (count($_slots) < 2) {
                            if($_slots[0]->shift === 'after'){
                                $slots_ = [
                                    'after' => [$_slots[0]->start, $_slots[0]->end]
                                ];
                            }
                            else if($_slots[0]->shift === 'before'){
                                $slots_ = [
                                    'before' => [$_slots[0]->start, $_slots[0]->end]
                                ];
                            }
                        } else {
                            $slots_ = [
                                'before' => [$_slots[0]->start, $_slots[0]->end],
                                'after' => [$_slots[1]->start, $_slots[1]->end]
                            ];
                        }
                        require_once './logic/slots.php';
                        $slotsWithoutCheckingAppoitments = getSlots($slots_);
                        ?>
                        <?php if(empty($slotsWithoutCheckingAppoitments)): ?>
                            <div class="alert alert-danger mt-1 mb-1 p-2">NO SLOTS AVAILABLE {DOCTOR FULL DAY}</div>
                        <?php else: ?>
                            <?php $availableSlots = removeUnavailableSlots($slotsWithoutCheckingAppoitments, $apps); ?>
                            <div class="mt-1 mb-1">
                            <?php if(count($availableSlots) >= 1): ?>
                                <select name="start" id="start" class="form-control">
                                <?php for ( $i  = 0 ; $i < count($availableSlots) ;$i++ ) {
                                    $slot = $availableSlots[$i];
                                ?>
                                    <option value="<?php echo $slot; ?>"><?php echo date('h:i A', strtotime($slot)) . ' to ' . date('h:i A', strtotime('+30 minutes', strtotime($slot))); ?></option>
                                <?php } ?>
                            </select>
                            <?php else : ?>
                                <div class="alert alert-info"> it s a full day appointments</div>
                            <?php endif; ?>
                            </div>
                            <button type="submit" name="app" class="btn btn-primary mt-1">Book an Appointment</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </form>
                <?php endif; ?>
                <br>
                <br>

                <!-- Your child form -->
                <form id="child" action="schedule.php" method="get">
                    <input type="hidden" name="doctorId" value="<?=$id;?>">
                    <?php if(isset($daySelected)):?>
                        <input type="date" name="day" id="daySelected" class="form-control" required value="<?=$daySelected?>" onchange="c()">
                    <?php else : ?>
                        <input type="date" name="day" id="" required class="form-control">
                    <?php endif;?>
                    <button type="button" onclick="submit()" class="btn btn-dark mt-1">Check Availability</button>
                </form>

            </div>
            <?php  if(isset($_GET['day'])): ?>
                <div class="col-md-3" style="background:blue">
                <!-- Accepted Appointments Schedule -->
                <h2>Doctor Appointments Schedule in <b style="color:white"><?=strtolower(date("l", strtotime($_GET['day'])))?></b>
                </h2>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <!-- Add more table headers if needed -->
                            </tr>
                        </thead>
                        <?php if(isset($_GET['day'])):?>
                        <tbody>
                            <?php foreach($apps as $app):?>
                                <tr>
                                <td>
                                <?= date("H:i:s", strtotime($app->start));?>
                                </td>
                                <td>
                                    <?= date("H:i:s", strtotime($app->end));?>
                                </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <?php endif; ?>
                    </table>
                </div>
            </div>  
            <?php endif; ?>
        </div>
        <?php
        $apps = $schedule = getSchedule($_GET['doctorId']);
        ?>
        <div class="row mt-2">  
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Day</th>
                        <th scope="col">Shift</th>
                        <th scope="col">Start</th>
                        <th scope="col">End</th>
                        <th scope="col">Room</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($schedule as $s): ?>
                    <tr>
                        <td>
                            <?=$s->day?>
                        </td>
                        <td>
                        <?php
                            if($s->shift === 'before') echo '<p style="color:blue">morning shift</p>';
                            else echo '<p style="color:red">night shift</p>';
                            ?>
                        </td>
                        <td>
                            <?=$s->start?>
                        </td>
                        <td>
                            <?=$s->end?>
                        </td>
                        <td>
                            <?=$s->room->number?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

</html>
<?php 
if(!isset($_SESSION['user'])){
    header("LOCATION:patientLogin.php");
}
?>