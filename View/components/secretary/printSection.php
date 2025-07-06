<style>
    .form-control {
            display: flex;
            gap: 10px;
        }

        input[type="number"]{
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff; /* Dark color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #007bfe; /* Darker color on hover */
        }
</style>
<?php
$apps = getAllCompletedAppointment();
if(isset($_GET['key'])){
    $phone =  $_GET['key'];
    $apps = getAllCompletedAppointmentsByPhone($phone);
}
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?=$_SESSION['message'];?></div>
            <?php unset($_SESSION['message']); endif; ?>
            <h1> Print Appointments Details</h1>
            <br>
            <div class="container">
                <form action="./home.php" post="get" class="search-from">
                    <input type="number" name="key" placeholder="Phone Number">
                    <input type="hidden" name="section" id="" value="print">
                    <button type="submit">Search</button>
                </form>
            </div>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Picture</th>
                        <th>Doctor</th>
                        <th>Patient</th>
                        <th>Created At</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each appointment and display its information
                    foreach ($apps as $app) {
                    ?>
                    <tr>
                        <td><img src="../images/<?=$app->doctor->picture;?>" alt="Doctor Picture" width="90"></td>
                        <td><?=$app->doctor->firstName;?> <?=$app->doctor->lastName;?></td>
                        <td><?=$app->patient->firstName;?> <?=$app->patient->lastName;?></td>
                        <td><?=$app->createdAt;?></td>
                        <td><?=$app->start;?></td>
                        <td><?=$app->end;?></td>
                        <?php
                            // Get the current date and time
                            $currentDateTime = date("Y-m-d H:i:s"); // Format: Year-Month-Day Hours:Minutes:Seconds

                            // Calculate the start time of the appointment 4 hours before
                            $fourHoursBeforeStart = date("Y-m-d H:i:s", strtotime($app->start) - 4 * 60 * 60);

                            // Check if the current date and time is within 4 hours before the start time or after the end time
                            if ($currentDateTime >= $fourHoursBeforeStart || $currentDateTime <= $app->end) {
                        ?>
                        <td><a href="../../post/appointment.php?idToPrint=<?=$app->id?>" class="btn btn-dark" style='background-color:green;'>Print</a></td>
                        <?php } ?>

                        <td>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
