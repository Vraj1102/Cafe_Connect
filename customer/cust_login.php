<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("../config/conn_db.php"); include('../includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="../assets/css/login.css" rel="stylesheet">

    <title>Log in | Sai Cafe</title>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="/Sai Cafe/index.php">
                <img src="/Sai Cafe/assets/img/Leaf logo.jpeg" width="70" class="me-2" alt="Sai Cafe Logo">
            </a>
        </div>
    </header>

    <div class="container form-signin mt-auto">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back 
        </a>
        <form method="POST" action="../includes/check_login.php" class="form-floating">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-door-open me-2"></i>Log In</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd" required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-success mb-3" type="submit">Log In</button>
            <a class="nav nav-item text-decoration-none text-muted mb-2 small" href="/Sai Cafe/shop/shop_login.php">
                <i class="bi bi-shop me-2"></i>Log in to your shop account
            </a>
            <a class="nav nav-item text-decoration-none text-muted mb-2 small" href="/Sai Cafe/customer/cust_forgot_pwd.php">
                <i class="bi bi-key me-2"></i>Forgot your password?
            </a>
            <a class="nav nav-item text-decoration-none text-muted mb-2 small" href="/Sai Cafe/customer/cust_regist.php">
                <i class="bi bi-person-plus me-2"></i>Create your new account
            </a>
        </form>
    </div>

    <footer class="text-center text-white">
  <!-- Copyright -->
  <div class="text-center p-2 p-2 mb-1 bg-dark text-white">
    <p class="text-white">© 2024 Copyright : Sai Group</p>
    <p class="text-white">Developed by :</p>
    <p class="text-white">&nbsp;1. Vraj
        &nbsp;2. Raj
        &nbsp;3. Saikiran</p>
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>
