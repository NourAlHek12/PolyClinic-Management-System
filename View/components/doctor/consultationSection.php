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

        .table-details summary {
            font-weight: bold;
            cursor: pointer;
        }

        .table-details p {
            margin: 5px 0;
        }
    </style>
<?php
$apps = getAllConsultations($_SESSION['id']);
if(isset($_GET['key'])){
    if(isset($_GET['keyAsDate']) && $_GET['keyAsDate'] != ''){
        $apps = getSingleConsultationRecordsByDate($_GET['keyAsDate'],$_SESSION['id']);
    }
    else if($_GET['key'] != ''){
        $apps = getSingleConsultationRecords($_GET['key'],$_SESSION['id']);
    }
}
?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6">
            <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?=$_SESSION['message'];?></div>
            <?php unset($_SESSION['message']); endif; ?>
            <h3> Consultation Appointments Details</h3>
            <div class="container">
                <div class="form">
                    <div class="form-control">
                        <form action="" method="get">
                            <input type="text" name="key" placeholder="patient phone">
                            <input type="date" name="keyAsDate" id="">
                            <input type="hidden" name="search" value="1">
                            <input type="hidden" name="section" value="consultation">
                            <button type="submit" class="btn btn-dark" style='background-color:green'>Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($apps as $app): ?>
                        <tr>
                            <td>
                                <?= $app->appointment->patient->id."  ". $app->appointment->patient->firstName . " " . $app->appointment->patient->lastName ?>
                            </td>
                            <td>
                                <details class="table-details">
                                    <summary>Consultation Details</summary>
                                    <p><strong>Notes:</strong> <?= $app->notes ?></p>
                                    <p><strong>Allergy:</strong> <?= $app->allergy ?></p>
                                    <p><strong>Previous Treatment:</strong> <?= $app->previousTreatment ?></p>
                                    <p><strong>Laboratory Result:</strong> <?= $app->laboratoryResult ?></p>
                                    <p><strong>Current Treatment:</strong> <?= $app->currentTreatment ?></p>
                                </details>
                            </td>
                            <td>
                                
                            </td>
                            <td><details class="table-details">
                                    <summary>Appointment Details</summary>
                                    <p><strong>Start:</strong> <?= $app->appointment->start ?></p>
                                    <p><strong>End:</strong> <?= $app->appointment->end ?></p>
                                    <p><strong>Status:</strong> <?= $app->appointment->status ?></p>
                                    <p><strong>Fees:</strong> <?= $app->appointment->fees ?></p>
                                    <p><strong>secretary:</strong><?= $app->appointment->secretary->id ?></p>
                                    <p><strong>Created At:</strong> <?= $app->appointment->createdAt ?></p>
                                </details>
                                
                            </td>
                            <td>
                            <form action="../../post/consultation.php?id=<?=$app->id?>" method="post">
                                    <input type="hidden" name="consultationId" value="<?= $app->id ?>">
                                    <button type="submit" class="btn btn-danger" style='background-color:red'>Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
