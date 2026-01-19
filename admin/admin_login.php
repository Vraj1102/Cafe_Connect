<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); 
    include("../config/conn_db.php"); 
    include('../includes/head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../assets/css/login.css" rel="stylesheet">
    <link href="../img/landing-logo.png" rel="icon">
    <title>Admin Login | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="/CafeConnect/index.php">
                <img src="/D:\xampp\htdocs\CafeConnect\assets\img\landing_logo.png" width="75" class="me-2" alt="CafeConnect Logo">
            </a>
        </div>
    </header>

    <div class="container form-signin mt-auto">
        <form method="POST" action="check_admin_login.php" class="form-floating">
            <h2 class="mt-5 mb-3 fw-normal text-bold"><i class="bi bi-door-open me-2"></i>Admin Log In</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd" required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-success mb-3" type="submit">Log In</button>
        </form>
    </div>

    <?php include('../includes/footer_customer.php'); ?>
</body>

</html>