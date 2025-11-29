<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("../config/conn_db.php"); include('../includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/login.css" rel="stylesheet">

    <title>SHOP LOG IN | Sai Cafe</title>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-expand-md navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="/Sai Cafe/index.php">
                <img src="/Sai Cafe/assets/img/Leaf logo.jpeg" width="75" class="me-2" alt="Sai Cafe Logo">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarCollapse">
                <div class="d-flex text-end"></div>
            </div>
        </div>
    </header>
    
    <div class="container form-signin">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back 
        </a>
        <form method="POST" action="check_shop_login.php" class="form-floating">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-door-open me-2"></i>Shop Log In</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd">
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-success mb-3" type="submit">Log In</button>
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