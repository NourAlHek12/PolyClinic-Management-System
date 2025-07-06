<?php include '../../utils/autoLoad.php'; ?>
<?php include '../../utils/connectToDb.php'; ?>
<?php include '../../Controller/specialityController.php'; ?>
<?php include '../../Controller/appointmentController.php'; ?>
<?php include '../../Controller/notificationController.php'; ?>
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
    </style>

</head>
<body>
<!-- <?php include '../components/header.php';?> -->
<?php 
$notes = getNotificationsByPatientId($_SESSION['id']);
?>
<br>

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
        <h1 class="title">Notifications Section</h1>
    </div>
    <?php if(empty($notes)): ?>
        <div class="alert alert-info mt-5 mb-5" style='width:50%; margin-left:110px'>No Notifications Yet</div>
        <div class="alert mb-5"></div>
        <div class="alert mb-5"></div>
        <?php else : ?>
        <div class="row">
        <table>
            <thead>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </thead>
            <tbody>
                <?php foreach($notes as $note): ?>
                    <tr>
                        <td width="70">
                            <a href="app.php" class="btn btn-dark" style='background-color:blue; margin-left:130px'>Show</a>
                        </td>
                        <td>
                            <?=$note->createdAt?>
                        </td>
                        <td>
                            <?=$note->content?>
                        </td>
                    </tr>
                    <tr>
                        <td><div class="alert mb-1"></div></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>


</body>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</html>