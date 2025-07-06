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
        body {
            background-color: #f4f4f9;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.3);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-top: 50px;
        }
        .login-container h3 {
            color: #007bff;
        }
        .form-group i {
            position: absolute;
            margin-left: 10px;
            margin-top: 10px;
            color: #007bff;
        }
        .form-group input {
            padding-left: 30px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .alert-danger {
            background-color: #007bff;
            color: white;
        }
        .form-group label {
            margin-left: 30px;
            transform: translateY(20%);
        }
    </style>

</head>

<body>
    <!-- <?php include '../components/header.php'; ?> -->
    
    <br>
    <div class="container">
        <div class="alert alert-danger text-center"  style="background-color: blue; color: white;"> Hello Doctor!</div>
        <div class="container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4 login-container">
                        <h3 class="text-center mb-4">Login</h3>
                        <form action="../../post/auth.php" method="post">
                            <?php if (isset($_SESSION['message'])) : ?>
                                <div class="alert alert-danger"><?=$_SESSION['message'];?></div>
                            <?php unset($_SESSION['message']); endif; ?>
                            <div class="form-group">
                                <i class="fas fa-envelope"></i>
                                <label for="username">Gmail</label>
                                <input type="text" class="form-control" id="gmail" name="gmail" required>
                            </div>
                            <div class="form-group">
                                <i class="fas fa-lock"></i>
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" name="auth" value="doctor" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>