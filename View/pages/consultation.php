<?php include '../../utils/autoLoad.php'; ?>
<?php include '../../utils/connectToDb.php'; ?>
<?php include '../../Controller/specialityController.php'; ?>
<?php include '../../Controller/appointmentController.php'; ?>
<?php include '../../Controller/consultationController.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <link rel="shortcut icon" href="../images/icons8-clinic-16.png" type="image/icon">
    <title>Polyclinic</title>
    <style>
        .button-container {
            display: flex;
            justify-content: center;
        }

        .button-container .btn {
            margin: 0 5px; /* Adjust margin as needed */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-left: 120px;
            margin-right: -50px; 
            padding: 8px;
            text-align: left;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .title {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .rounded-img {
            border-radius: 50%;
        }

        details summary {
            cursor: pointer;
        }

        /* Table specific styles */
        .consultation-table {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .consultation-table th, .consultation-table td {
            padding: 15px;
        }

        .consultation-table th {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .consultation-table td {
            border-bottom: 1px solid #dee2e6;
        }

        .consultation-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .consultation-table tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>

</head>
<body>
<!-- <?php include '../components/header.php';?> -->
<?php 
$cons = getPatientConsultation($_SESSION['id']);
?>
<div class="mt-5 mb-2">
    <br>
</div>
<div class="container mt-2">
    <div class="row">
    <div class="col-md-2">
                <a href="#" class="btn btn-primary" onclick="goBack()" style='background-color: green;'>Back</a>
                <a href="../../post/logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <br>
        <div class="button-container">
            <a href="app.php" class="btn btn-primary">Appointments</a>
            <a href="notification.php" class="btn btn-primary">Notifications</a>
            <a href="consultation.php" class="btn btn-primary">Consultations</a>  
        </div>
        <br>
        <h1 class="title">Your Consultations</h1>
    </div>
    <div class="row">
        <?php if(!empty($cons)): ?>
            <table>
            <thead>
                <td>
                    Profile
                </td>
                <td>
                    Doctor
                </td>
                <td>
                    Consultation info
                </td>
                <td>
                    App info
                </td>
            </thead>
            <tbody>
                <?php foreach($cons as $con): ?>
                    <tr>
                        <td>
                            <img src="../images/<?=$con->appointment->doctor->picture?>" alt="" class="rounded-img" width="90">
                        </td>
                        <td>
                            <?=$con->appointment->doctor->firstName?> <?=$con->appointment->doctor->lastName?>
                        </td>
                        <td>
                        <?php $app = $con; ?>
                        <details>
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
                        <details>
                                <summary>Consultation Details</summary>
                                <p><strong>current treat:</strong> <?= $app->currentTreatment ?></p>
                                <p><strong>prev treat:</strong> <?= $app->previousTreatment ?></p>
                                <p><strong>lab res:</strong> <?= $app->laboratoryResult ?></p>
                                <p><strong>allergy:</strong> <?= $app->allergy ?></p>
                                <p><strong>notes:</strong><?= $app->notes ?></p>
                            </details>
                        </td>
                        
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info mt-5 mb-5" style='width:50%; margin-left:130px'>
                No Appoitments Yet
            </div>
            <div class="alert mt-5"></div>
            <div class="alert mt-2"></div>
        <?php endif; ?>
    </div>
</div>
</body>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</html>