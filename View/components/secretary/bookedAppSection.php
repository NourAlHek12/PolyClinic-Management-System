<style>
    .form-control {
            display: flex;
            gap: 10px;
        }

        input[type="text"], input[type="date"]{
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
$apps = getAllBookedAppointments();
if(isset($_GET['keyAsName']) ||isset( $_GET['keyAsDate'])){
    if($_GET['keyAsName'] != '' && $_GET['keyAsDate'] != ''){
        $apps = showAllBookedAppointmentsByStartDateAndDoctorName($_GET['keyAsDate'], $_GET['keyAsName']);
    }
    else if ($_GET['keyAsName'] != ''){
        $apps = showAllBookedAppointmentsByDoctorName($_GET['keyAsName']);
    }
    else if ($_GET['keyAsDate'] != ''){
        $apps = showAllBookedAppointmentsByStartDate($_GET['keyAsDate']);
    }
}
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?=$_SESSION['message'];?></div>
            <?php unset($_SESSION['message']); endif; ?>
            <h1>Appointments Details</h1>
            <br>
            <div class="container">
                <form action="./home.php" post="get" class="search-form">
                    <input type="text" placeholder="doctor_name" name="keyAsName">
                    <input type="date" name="keyAsDate">
                    <input type="hidden" name="section" id="" value="bookedApp">
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
                        <td>
                            <a href="../../post/appointment.php?id=<?= $app->id ?>&action=rejected" class="btn btn-danger mb-2">Reject</a>
                            <a href="../../post/appointment.php?id=<?= $app->id ?>&action=accepted" class="btn btn-success mb-2">Accept</a>
                            <a href="../../post/appointment.php?id=<?= $app->id ?>&action=block" class="btn btn-dark mb-2"
                            onclick="return confirm('Are you sure you want to block this patient?');"
                            >Block</a>
                        </td>
                        <td>
                        <?php if(isset($_GET['appId'])):?>
                        <td>
                            <form action="../../post/appointment.php" method="post">
                                <div class="form-control">
                                <input type="number" name="fees" id="">
                                </div>
                                <input type="hidden" name="id" value="<?= $app->id ?>">
                                <div class="mt-5">
                                <button class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </td>
                        <?php endif; ?>
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
