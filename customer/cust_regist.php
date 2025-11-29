<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("../config/conn_db.php"); include('../includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/login.css" rel="stylesheet">

    <title>Customer Registration | CafeConnect</title>
</head>

<body class="d-flex flex-column">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm mb-auto" style="height: 60px;">
        <div class="container-fluid mx-4">
            <a href="/CafeConnect/index.php">
            <img src="/CafeConnect/assets/img/landing_logo.png" width="50" class="me-2" alt="CafeConnect Logo">
            </a>
        </div>
    </header>
    <div class="container" style="margin-top: 70px;"></div>
    <div class="container form-signin mt-auto">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <form method="POST" action="/CafeConnect/customer/add_cust.php" class="form-floating">
            <h2 class="mt-4 mb-3 fw-normal text-bold"><i class="bi bi-person-plus me-2"></i>Register here...</h2>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="username" placeholder="Username" name="username"
                    minlength="5" maxlength="45" required>
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="pwd" placeholder="Password" name="pwd" minlength="8"
                    maxlength="45" required>
                <label for="pwd">Password</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="cfpwd" placeholder="Confirm Password" minlength="8"
                    maxlength="45" name="cfpwd" required>
                <label for="cfpwd">Confirm Password</label>
                <div id="passwordHelpBlock" class="form-text smaller-font">
                    Your password must be at least 8 characters long.
                </div>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname"
                    required>
                <label for="firstname">First Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="lastname" placeholder="Last Name" name="lastname" required>
                <label for="lastname">Last Name</label>
            </div>
            <div class="form-floating mb-2">
                <input type="email" class="form-control" id="email" placeholder="E-mail" name="email" required>
                <label for="email">E-mail</label>
            </div>
            <div class="form-floating">
                <select class="form-select mb-2" id="gender" name="gender">
                    <option selected value="-">---</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                    <option value="N">Others</option>
                </select>
                <label for="gender">Your Gender</label>
            </div>
            <button class="w-100 btn btn-success mb-3" type="submit">Register</button>
        </form>
    </div>
    <div class="container mt-4"></div>
    <?php include('../includes/footer_customer.php'); ?>
</body>

</html>
