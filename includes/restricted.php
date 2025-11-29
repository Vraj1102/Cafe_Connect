<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
    <title>Access Restricted - CafeConnect</title>
</head>
<body class="d-flex flex-column h-100">
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-shield-exclamation text-danger" style="font-size: 4rem;"></i>
                        <h2 class="mt-3">Access Restricted</h2>
                        <p class="text-muted">You don't have permission to access this page.</p>
                        <a href="/CafeConnect/index.php" class="btn btn-primary">
                            <i class="bi bi-house"></i> Go Home
                        </a>
                        <a href="/CafeConnect/auth_login.php" class="btn btn-outline-primary">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>