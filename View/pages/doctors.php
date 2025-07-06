<?php include '../../utils/autoLoad.php'; ?>
<?php include '../../utils/connectToDb.php'; ?>
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
<!-- <?php include '../components/header.php';?> -->
<?php
if(!isset($_GET['specialty'])){
    header("LOCATION:home.php");
}
$id = $_GET['specialty'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Doctors Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .button-container {
            display: flex;
            justify-content: center;
        }

        .button-container .btn {
            margin: 0 5px; /* Adjust margin as needed */
        }
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table th:first-child,
        .table td:first-child {
            border-left: none;
        }

        .table th:last-child,
        .table td:last-child {
            border-right: none;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
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
        <h1>All Doctors Information</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Gmail</th>
                        <th>Phone</th>
                        <th></th>
                        <!-- Add more table headers for additional information if needed -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../../Controller/doctorController.php';
                    // Fetch all doctors' information from the database
                    $doctors = getAllDoctorsBySpecialtyId($id);

                    // Loop through each doctor and display their information
                    foreach ($doctors as $doctor) {
                        echo "<tr>";
                        echo "<td><a href='schedule.php?doctorId=$doctor->id'><img src='../images/$doctor->picture' alt='Profile Picture' class='rounded-circle' width='90'></a></td>";
                        echo "<td>" . $doctor->firstName . "</td>";
                        echo "<td>" . $doctor->lastName . "</td>";
                        echo "<td>" . $doctor->gmail . "</td>";
                        echo "<td>" . $doctor->phone . "</td>";
                        echo "<td><a href='schedule.php?doctorId=$doctor->id' class='btn btn-dark' style='background-color: blue;'>Book</a></td>";
                        // Add more table data for additional information if needed
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    function goBack() {
        window.history.back();
    }
</script>
</html>

</html>
<?php 
if(!isset($_SESSION['user'])){
    header("LOCATION:patientLogin.php");
}
?>