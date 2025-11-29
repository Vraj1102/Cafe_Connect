<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../includes/head.php'); ?>
    <title>Registration Success - CafeConnect</title>
</head>
<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm">
        <div class="container-fluid mx-4">
            <a href="/CafeConnect/index.php">
                <img src="/CafeConnect/assets/img/Main Logo 2.jpeg" width="75" class="me-2" alt="CafeConnect">
            </a>
        </div>
    </header>

    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        <h2 class="mt-3 text-success">Registration Successful!</h2>
                        <p class="text-muted">Your account has been created successfully. You can now login to start ordering.</p>
                        <a href="/CafeConnect/auth_login.php" class="btn btn-success me-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login Now
                        </a>
                        <a href="/CafeConnect/index.php" class="btn btn-outline-primary">
                            <i class="bi bi-house"></i> Go Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center text-white mt-auto">
        <div class="bg-dark p-3">
            <p class="mb-0">© 2024 CafeConnect Team</p>
        </div>
    </footer>
</body>
</html>