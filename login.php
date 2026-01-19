<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); include("config/conn_db.php"); include('includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/login.css" rel="stylesheet">
    <title>Login | CafeConnect</title>
    <style>
        .login-type-selector {
            display: none;
            margin-bottom: 15px;
        }
        .login-type-selector.show {
            display: block;
        }
        .btn-group-toggle .btn {
            font-size: 12px;
            padding: 5px 10px;
        }
        .staff-login-link {
            font-size: 11px;
            color: #6c757d;
            text-decoration: none;
            opacity: 0.7;
        }
        .staff-login-link:hover {
            opacity: 1;
            color: #495057;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="index.php">
                <img src="assets/img/landing_logo.png" width="70" class="me-2" alt="CafeConnect Logo">
            </a>
        </div>
    </header>

    <div class="container form-signin mt-auto">
        <a class="nav nav-item text-decoration-none text-muted" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back 
        </a>
        
        <form method="POST" action="auth_process.php" class="form-floating" id="loginForm">
            <h2 class="mt-4 mb-3 fw-normal text-bold">
                <i class="bi bi-door-open me-2"></i>
                <span id="loginTitle">Customer Login</span>
            </h2>
            
            <!-- Login type selector -->
            <div class="login-type-selector" id="loginTypeSelector">
                <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                    <input type="radio" class="btn-check" name="loginType" id="customer" value="customer" checked>
                    <label class="btn btn-outline-primary" for="customer">Customer</label>
                    
                    <input type="radio" class="btn-check" name="loginType" id="admin" value="admin">
                    <label class="btn btn-outline-danger" for="admin">Admin</label>
                    
                    <input type="radio" class="btn-check" name="loginType" id="shop" value="shop">
                    <label class="btn btn-outline-success" for="shop">Shop</label>
                </div>
            </div>
            
            <div class="form-floating mb-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="Username" name="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="pwd" required>
                <label for="floatingPassword">Password</label>
            </div>
            <button class="w-100 btn btn-success mb-3" type="submit" id="loginBtn">Log In</button>
            
            <!-- Customer-specific links -->
            <div id="customerLinks">
                <a class="nav nav-item text-decoration-none text-muted mb-2 small d-block" href="customer/cust_forgot_pwd.php">
                    <i class="bi bi-key me-2"></i>Forgot your password?
                </a>
                <a class="nav nav-item text-decoration-none text-muted mb-2 small d-block" href="customer/cust_regist.php">
                    <i class="bi bi-person-plus me-2"></i>Create your new account
                </a>
            </div>
            
            <!-- Staff login link -->
            <div class="text-center mt-3">
                <a href="#" class="staff-login-link" onclick="showStaffLogin()">
                    <i class="bi bi-gear"></i> Staff Login
                </a>
            </div>
        </form>
    </div>

    <?php include('includes/footer_customer.php'); ?>

    <script>
        function showStaffLogin() {
            document.getElementById('loginTypeSelector').classList.add('show');
        }

        // Handle login type changes
        document.querySelectorAll('input[name="loginType"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const loginTitle = document.getElementById('loginTitle');
                const loginBtn = document.getElementById('loginBtn');
                const customerLinks = document.getElementById('customerLinks');
                
                if (this.value === 'admin') {
                    loginTitle.textContent = 'Admin Login';
                    loginBtn.className = 'w-100 btn btn-danger mb-3';
                    customerLinks.style.display = 'none';
                } else if (this.value === 'shop') {
                    loginTitle.textContent = 'Shop Owner Login';
                    loginBtn.className = 'w-100 btn btn-warning mb-3';
                    customerLinks.style.display = 'none';
                } else {
                    loginTitle.textContent = 'Customer Login';
                    loginBtn.className = 'w-100 btn btn-success mb-3';
                    customerLinks.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>