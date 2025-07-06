<?php include '../../utils/autoLoad.php'; ?>
<?php include '../../utils/connectToDb.php'; ?>
<?php include '../../Controller/specialityController.php'; ?>
<?php include '../../Controller/appointmentController.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="../css/home.css"> -->
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
            margin-right:-50px;
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

        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn-container .btn {
            flex: 1;
            margin-right: 10px;
        }

        .title {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .rounded-img {
            border-radius: 50%;
        }

        /* Table specific styles */
        .appointment-table {
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .appointment-table th, .appointment-table td {
            padding: 15px;
        }

        .appointment-table th {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .appointment-table td {
            border-bottom: 1px solid #dee2e6;
        }

        .appointment-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .appointment-table tbody tr:hover {
            background-color: #e9ecef;
        }

        .appointment-table .btn {
            padding: 5px 10px;
        }

        .no-appointments {
            margin-left: 130px;
            width: 50%;
        }
    </style>

</head>
<body>
<!-- <?php include '../components/header.php';?> -->
<?php 
$apps = showAllAppointmentsByPatient($_SESSION['id']);
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
        <h1 class="title">Your Appointments</h1>
    </div>
    <div class="row">
        <?php if(isset($_SESSION['message'])): ?>
            <div class="alert alert-info">
                <?=$_SESSION['message'];?>
            </div>
        <?php unset($_SESSION['message']); endif; ?>
        <?php if(!empty($apps)): ?>
            <table>
            <thead>
                <td>
                    Profile
                </td>
                <td>
                    Doctor
                </td>
                <td>
                    Booked At
                </td>
                <td>
                    Status
                </td>
                <td>
                    Action
                </td>
            </thead>
            <tbody>
                <?php foreach($apps as $app): ?>
                    <tr>
                        <td>
                            <img src="../images/<?=$app->doctor->picture?>" alt="" class="rounded-img" width="90">
                        </td>
                        <td>
                            <?=$app->doctor->firstName?> <?=$app->doctor->lastName?>
                        </td>
                        <td>
                            <?=$app->createdAt?>
                        </td>
                        <td>
                            <?=$app->status?>
                        </td>
                        <?php if($app->status === "booked"): ?>
                            <td>
                            <a href="../../post/appointment.php?delete=<?=$app->id?>" class="btn btn-danger">Delete</a>
                            </td>
                        <?php else: ?>
                            <td>
                            <div class="alert alert-info" style='width:80px;'>Cannot delete</div>
                            </td>
                        <?php endif; ?>
                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info mt-5 mb-5" style='width:50%; margin-left:130px'>
                No Appoitments yet
            </div>
            <div class="alert mt-5"></div>
            <div class="alert mt-2"></div>
        <?php endif; ?>
    </div>
</div>
<br>
<br>
<br>
<br>

</body>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</html>