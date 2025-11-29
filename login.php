<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("config/conn_db.php"); include('includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/login.css" rel="stylesheet">
    <title>Login - Sai Cafe</title>
    <style>
        .login-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm mb-auto">
        <div class="container-fluid mx-4">
            <a href="/Sai Cafe/index.php">
                <img src="/Sai Cafe/assets/img/Leaf logo.jpeg" width="75" class="me-2" alt="Sai Cafe Logo">
            </a>
        </div>
    </header>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-4">
                <h1 class="display-5 fw-bold">Welcome to Sai Cafe</h1>
                <p class="lead">Please select your login type</p>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center mb-5">
            <!-- Customer Login -->
            <div class="col">
                <div class="card login-card h-100 text-center border-0 shadow">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-person-circle text-primary" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">Customer</h3>
                        <p class="card-text text-muted">Login to browse shops and place orders</p>
                        <a href="/Sai Cafe/customer/cust_login.php" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Customer Login
                        </a>
                        <div class="mt-3">
                            <small class="text-muted">Don't have an account? 
                                <a href="/Sai Cafe/customer/cust_regist.php" class="text-decoration-none">Sign Up</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shop Owner Login -->
            <div class="col">
                <div class="card login-card h-100 text-center border-0 shadow">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-shop text-success" viewBox="0 0 16 16">
                                <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">Shop Owner</h3>
                        <p class="card-text text-muted">Manage your shop, menu and orders</p>
                        <a href="/Sai Cafe/shop/shop_login.php" class="btn btn-success btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Shop Login
                        </a>
                    </div>
                </div>
            </div>

            <!-- Admin Login -->
            <div class="col">
                <div class="card login-card h-100 text-center border-0 shadow">
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-shield-lock text-danger" viewBox="0 0 16 16">
                                <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z"/>
                            </svg>
                        </div>
                        <h3 class="card-title">Administrator</h3>
                        <p class="card-text text-muted">Manage system, shops and customers</p>
                        <a href="/Sai Cafe/admin/admin_login.php" class="btn btn-danger btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Admin Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-white mt-auto">
        <div class="text-center p-2 p-2 mb-1 bg-dark text-white">
            <p class="text-white">© 2024 Copyright : Sai Group</p>
            <p class="text-white">Developed by :</p>
            <p class="text-white">&nbsp;1. Vraj &nbsp;2. Raj &nbsp;3. Saikiran</p>
        </div>
    </footer>
</body>

</html>
