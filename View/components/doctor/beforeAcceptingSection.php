<style>
        .table {
            width: 200%;
            margin: 0 auto;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-top: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
<?php
$apps = getAllPendingAppointments($_SESSION['id']);
?>
<div class="container mt-5 mb-5">
   
    <div class="row">
        <div class="col-md-6">
            <h3> Pending Appointments Details</h3>
            <div class="container mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Created At</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop through each appointment and display its information
                        foreach ($apps as $app) {
                            if($app->doctor->id==$_SESSION['id']):
                        ?>
                        <tr id="row<?=$app->id;?>">
                            <td><?=$app->patient->firstName;?> <?=$app->patient->lastName;?></td>
                            <td><?=$app->createdAt;?></td>
                            <td><?=$app->start;?></td>
                            <td><?=$app->end;?></td>
                            <td>
                                <a href="../../post/appointment.php?id=<?= $app->id ?>&action=rejected" class="btn btn-danger mb-2" style='background-color:red'>Reject</a>
                            </td>
                        </tr>
                        <?php
                        endif;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
