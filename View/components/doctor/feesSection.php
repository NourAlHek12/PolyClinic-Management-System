<style>
        .container {
            margin-top: 50px;
        }

        .form {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-control {
            display: flex;
            gap: 10px;
        }

        input[type="text"], input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #343a40; /* Dark color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #23272b; /* Darker color on hover */
        }
        .custom-table {
            width: 200%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .custom-table th, .custom-table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .custom-table th {
            background-color: #f4f4f4;
        }

        .custom-table tr:hover {
            background-color: #f1f1f1;
        }

        .custom-table td img {
            border-radius: 50%;
        }
</style>
<?php
$apps = getAllCompletedAppointments($_SESSION['id']);
$fees = 0;
if(isset($_GET['key'])){
    if(isset($_GET['keyAsDate']) && $_GET['keyAsDate'] != ''){
        //$apps = getSingleConsultationRecordsByDate($_GET['keyAsDate']);
        $apps = getAllCompletedAppointmentsByDate($_GET['keyAsDate'],$_SESSION['id']);
    }
    else if($_GET['key'] != ''){
        //$apps = getSingleConsultationRecords($_GET['key']);
        $apps = getAllCompletedAppointmentsByPatientPhone($_GET['key'],$_SESSION['id']);
    }
}
for($i=0;$i<count($apps);$i++){
    $fees += $apps[$i]->fees;
}
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6">
            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?=$_SESSION['message'];?></div>
            <?php unset($_SESSION['message']); endif; ?>
            <h3>Accepted Appointments Details</h3>
            <h4 class="container"><b>Total Fees :</b> <?=$fees?> $</h4>
            <div class="container">
                <div class="form">
                    <div class="form-control">
                        <form action="" method="get">
                            <input type="text" name="key" placeholder="patient phone">
                            <input type="date" name="keyAsDate" id="">
                            <input type="hidden" name="search" value="1">
                            <input type="hidden" name="section" value="fess">
                            <button type="submit" class="btn btn-dark" style='background-color:green'>Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Created At</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Fees</th>
                            <th>Action</th>
                            <?php if(isset($_GET['appId'])):?>
                            <th>Manage Consultation</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through each appointment and display its information
                        foreach ($apps as $app) {
                        ?>
                        <tr id="row<?=$app->id;?>">
                            <td><?=$app->patient->firstName;?> <?=$app->patient->lastName;?></td>
                            <td><?=$app->createdAt;?></td>
                            <td><?=$app->start;?></td>
                            <td><?=$app->end;?></td>
                            <td><?=$app->fees;?>$</td>
                            <td>


                                <?php if ($app->status === "accepted"): ?>
                                    <a href="home.php?appId=<?= $app->id ?>&section=fess" class="btn btn-dark" style='background-color: #007bff;'>Manage Consultation</a>
                                <?php endif; ?>

                            </td>
                            <td>
                            <?php if(isset($_GET['appId']) && $_GET['appId'] === $app->id):?>
                            <?php 
                            // Redirect to the desired section with appId parameter
                            $redirectUrl = "home.php?appId=" . $_GET['appId'] . "&section=fess#row" . $_GET['appId'];
                            echo "<script>window.location.href='$redirectUrl';</script>";
                            ?>
                            <?php endif; ?>

                            <?php if(isset($_GET['appId']) && $_GET['appId'] === $app->id):?>

                            <td>
                                <form action="../../post/consultation.php" method="post" >
                                    <div class="form-control">
                                        <input type="text" name="notes" id="" required placeholder="enter appointment notes">
                                    </div>
                                    <div class="form-control">
                                        <input type="text" name="allergy" id="" required placeholder="enter patient allergy">
                                    </div>
                                    <div class="form-control">
                                        <input type="text" name="prevTreat" id="" placeholder="enter prev treat">
                                    </div>
                                    <div class="form-control">
                                        <input type="text" name="currentTreat" id="" placeholder="enter current Tread">
                                    </div>
                                    <div class="form-control">
                                        <input type="text" name="labResult" required id="" placeholder="enter lab result">
                                    </div>


                                    <input type="hidden" name="appId" value="<?= $app->id ?>">
                                    <div class="mt-3 ml-2">
                                        <button type="submit" name="consultation" class="btn btn-success text-center" style='background-color: #007bff;'>Save</button>
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
</div>
