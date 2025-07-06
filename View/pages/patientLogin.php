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
        .header, .footer {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        .footer a {
            color: white;
        }
        .footer a:hover {
            color: #ffdd57;
        }
        .form-group label {
            margin-left: 30px;
            /* position: absolute; */
            /* top: 50%; */
            transform: translateY(20%);
        }
    </style>
</head>

<body>
    <!-- Simple Header -->
    <header class="header">
        <h1>Welcome to Polyclinic</h1>
    </header>
    
    <br>
    <div class="container">
        <div class="alert alert-danger text-center">Hello Patient!</div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 login-container">
             
                <form action="../../post/auth.php" method="post"
                <?php if (isset($_GET['form']) && $_GET['form'] == 'signup') : ?>
                onsubmit="return regex()"
                <?php endif; ?>>
                    <?php if (isset($_SESSION['message'])) : ?>
                        <div class="alert alert-danger"><?=$_SESSION['message'];?></div>
                        <?php unset($_SESSION['message']); endif; ?>
                    <?php if (isset($_GET['form']) && $_GET['form'] == 'signup') : ?>
                        <div class="form-group position-relative mb-3">
                            <i class="fas fa-user"></i>
                            <label for="fn">First Name</label>
                            <input type="text" class="form-control" id="fn" name="fn" required>
                        </div>
                        <div class="form-group position-relative mb-3">
                            <i class="fas fa-user"></i>
                            <label for="ln">Last Name</label>
                            <input type="text" class="form-control" id="ln" name="ln" required>
                        </div>
                        <div class="form-group position-relative mb-3">
                            <i class="fas fa-phone"></i>
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    <?php endif; ?>
                    <div class="form-group position-relative mb-3">
                        <i class="fas fa-envelope"></i>
                        <label for="gmail">Gmail</label>
                        <input type="email" class="form-control" id="gmail" name="gmail" required>
                    </div>
                    <div class="form-group position-relative mb-3">
                        <i class="fas fa-lock"></i>
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group mb-3">
                        <?php if (!isset($_GET['form'])) { ?>
                            <button type="submit" name="auth" value="patient" class="btn btn-primary btn-block">Login</button>
                            <span class="d-block text-center mt-2">Not having an account? <a href="./patientLogin.php?form=signup" style="color: red;">Sign Up</a></span>
                        <?php } else { ?>
                            <button type="submit" name="auth" value="up" class="btn btn-primary btn-block">Sign Up</button>
                            <span class="d-block text-center mt-2">Having an account? <a href="./patientLogin.php" style="color: red;">Login</a></span>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <!-- Improved Footer -->
    <!-- <footer class="footer mt-auto py-3">
        <div class="container">
            <p>&copy; 2024 Polyclinic. All rights reserved.</p>
            <p>
                <a href="#" class="text-white">Privacy Policy</a> |
                <a href="#" class="text-white">Terms of Service</a>
            </p>
        </div>
    </footer> -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function regex() {
            const password = document.getElementById('password').value;
            const regexPattern = /^(?=.*\d.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{6,}$/;
    
            // Test if the password matches the regex pattern
            if (regexPattern.test(password)) {
                return true;
            } else {
                alert('Password is invalid');
                return false;
            }
       
