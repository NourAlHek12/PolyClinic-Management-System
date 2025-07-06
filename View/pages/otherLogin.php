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
        .login-container {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
        .login-container h3 {
            margin-bottom: 20px;
        }
        .form-group span {
            display: inline-block;
            margin-top: 10px;
        }
        .alert {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>
    <!-- <?php include '../components/header.php'; ?> -->
    <div class="container mt-5">
        <div class="alert alert-danger text-center">Administration</div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 mt-5">
                <div class="login-container">
                    <h3 class="text-center mb-4">Login</h3>
                    <form action="../../post/auth.php" method="post">
                        <?php if (isset($_SESSION['message'])) : ?>
                            <div class="alert alert-danger"><?=$_SESSION['message'];?></div>
                        <?php unset($_SESSION['message']); endif; ?>
                        <div class="form-group mb-3">
                            <label for="username">
                                <i class="fas fa-user" style='color:blue;'></i> <?php echo isset($_GET['manager']) ? 'ID' : 'Phone'; ?>
                            </label>
                            <input type="<?php echo isset($_GET['manager']) ? 'text' : 'number'; ?>" 
                                   class="form-control" id="<?php echo isset($_GET['manager']) ? 'id' : 'phone'; ?>" 
                                   name="<?php echo isset($_GET['manager']) ? 'id' : 'phone'; ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">
                                <i class="fas fa-lock" style='color:blue;'></i> Password
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="auth" value="<?php echo isset($_GET['manager']) ? 'man' : 'sec'; ?>" 
                                    class="btn btn-primary btn-block">
                                Login as <?php echo isset($_GET['manager']) ? 'Manager' : 'Secretary'; ?>
                            </button>
                            <span style="color:red">
                                Login as a <a href="otherLogin.php?<?php echo isset($_GET['manager']) ? 'sec=auth' : 'manager=auth'; ?>">
                                    <?php echo isset($_GET['manager']) ? 'Secretary' : 'Manager'; ?>
                                </a>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
