<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("../config/conn_db.php"); include('../includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/login.css" rel="stylesheet">

    <title>Reset password failed | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="index.php">
                <img src="/CafeConnect/assets/img/landing_logo.png" width="75" class="me-2" alt="CafeConnect Logo">
            </a>
        </div>
    </header>
    <div class="mt-5"></div>
    <div class="container form-signin text-center reg-fail mt-auto">
            <i class="mt-4 bi bi-exclamation-circle text-danger h1 display-2"></i>
            <h3 class="mt-2 mb-3 fw-normal text-bold">Unable to reset your password</h3>
            <p class="mb-3 fw-normal text-bold">Sorry, we have encountered with the error.<br/>
                <code>
                    <?php
                        $error_code = $_GET["err"];
                        echo "Error Code: {$error_code}";
                    ?>
                </code>
            </p>
            <a class="btn btn-danger btn-sm w-50" href="index.php">Return to Home</a>
    </div>

    <footer class="text-center text-white">
  <!-- Copyright -->
  <div class="text-center p-2 p-2 mb-1 bg-dark text-white">
    <p class="text-white">© 2024 Copyright : CafeConnect</p>
    <p class="text-white">Developed by : Vraj Patel</p>
  </div>
  <!-- Copyright -->
</footer>
</body>

</html>
