<?php
session_start();
require_once 'config/conn_db.php';

$error = '';

// Redirect if already logged in
if (isset($_SESSION['cid']) || isset($_SESSION['sid']) || isset($_SESSION['aid'])) {
    if (isset($_SESSION['aid'])) {
        header("Location: /CafeConnect/admin/admin_home.php");
    } elseif (isset($_SESSION['sid'])) {
        header("Location: /CafeConnect/shop/shop_home.php");
    } else {
        header("Location: /CafeConnect/index.php");
    }
    exit();
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter username and password';
    } else {
        $authenticated = false;
        
        if ($role === 'admin') {
            // Check admin table
            $stmt = $mysqli->prepare("SELECT admin_id, admin_username, admin_pwd, admin_firstname, admin_lastname FROM admin WHERE admin_username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $admin = $result->fetch_assoc();
                if ($admin['admin_pwd'] === $password) {
                    $_SESSION['aid'] = $admin['admin_id'];
                    $_SESSION['firstname'] = $admin['admin_firstname'];
                    $_SESSION['lastname'] = $admin['admin_lastname'];
                    $_SESSION['utype'] = 'ADMIN';
                    header("Location: /CafeConnect/admin/admin_home.php");
                    exit();
                }
            }
        } elseif ($role === 'customer') {
            // Check customer table
            $stmt = $mysqli->prepare("SELECT c_id, c_username, c_pwd, c_firstname, c_lastname FROM customer WHERE c_username = ? AND c_type != 'ADM'");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if ($user['c_pwd'] === $password) {
                    $_SESSION['cid'] = $user['c_id'];
                    $_SESSION['firstname'] = $user['c_firstname'];
                    $_SESSION['lastname'] = $user['c_lastname'];
                    $_SESSION['utype'] = 'customer';
                    header("Location: /CafeConnect/customer/home.php");
                    exit();
                }
            }
        }
        
        if ($role === 'shop' && !$authenticated) {
            // Check shop table
            $stmt = $mysqli->prepare("SELECT s_id, s_username, s_pwd, s_name FROM shop WHERE s_username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $shop = $result->fetch_assoc();
                if ($shop['s_pwd'] === $password) {
                    $_SESSION['sid'] = $shop['s_id'];
                    $_SESSION['username'] = $shop['s_username'];
                    $_SESSION['shopname'] = $shop['s_name'];
                    $_SESSION['utype'] = 'shopowner';
                    header("Location: /CafeConnect/shop/shop_home.php");
                    exit();
                }
            }
        }
        
        if (!$authenticated) {
            $error = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('includes/head.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CafeConnect</title>
    <style>
        html, body { height: 100%; }
        body { 
            padding-top: 76px; 
            display: flex;
            flex-direction: column;
        }
        .content-wrapper { flex: 1 0 auto; }
        footer { flex-shrink: 0; }
        .role-selector { display: none; }
        .role-selector.active { display: block; }
        .role-btn { cursor: pointer; transition: all 0.3s; }
        .role-btn:hover { transform: translateY(-2px); }
        .role-btn.selected { border: 3px solid #0d6efd; box-shadow: 0 0 15px rgba(13,110,253,0.5); }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <header class="navbar navbar-light fixed-top bg-light shadow-sm">
        <div class="container-fluid mx-4">
            <a href="/CafeConnect/index.php">
                <img src="/CafeConnect/assets/img/landing_logo.png" width="75" class="me-2" alt="CafeConnect">
            </a>
        </div>
    </header>

    <div class="content-wrapper">
        <div class="container mt-5 pt-5">
            <a class="nav nav-item text-decoration-none text-muted mb-3 d-inline-block" href="/CafeConnect/index.php">
                <i class="bi bi-arrow-left-square me-2"></i>Back to Home
            </a>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">
                            <i class="bi bi-shield-lock"></i> Login
                        </h2>
                        
                        <?php if ($error): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <!-- Role Selection -->
                        <div id="roleSelection" class="mb-4">
                            <p class="text-center text-muted mb-3">Select your role to continue</p>
                            <div class="row g-3">
                                <div class="col-4">
                                    <div class="role-btn card text-center p-3" onclick="selectRole('customer')">
                                        <i class="bi bi-person-circle text-primary" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2 small">Customer</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="role-btn card text-center p-3" onclick="selectRole('shop')">
                                        <i class="bi bi-shop text-success" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2 small">Shop Owner</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="role-btn card text-center p-3" onclick="selectRole('admin')">
                                        <i class="bi bi-shield-check text-danger" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2 small">Admin</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" id="loginForm" class="role-selector">
                            <input type="hidden" name="role" id="selectedRole">
                            
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" name="username" required autofocus>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                            
                            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetRole()">
                                <i class="bi bi-arrow-left"></i> Change Role
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                New customer? <a href="/CafeConnect/customer/cust_regist.php">Sign Up</a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <footer class="text-light" style="background: linear-gradient(135deg, #2C1810 0%, #8B4513 50%, #D2691E 100%);">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <img src="/CafeConnect/assets/img/landing_logo.png" width="30" class="me-2" alt="CafeConnect">
                        <div>
                            <p class="mb-0 text-white fw-bold">CafeConnect</p>
                            <small class="text-light fst-italic">Brewing Connections</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <p class="mb-0 text-light">© 2024 CafeConnect. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function selectRole(role) {
            document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            document.getElementById('selectedRole').value = role;
            document.getElementById('roleSelection').style.display = 'none';
            document.getElementById('loginForm').classList.add('active');
        }
        
        function resetRole() {
            document.getElementById('roleSelection').style.display = 'block';
            document.getElementById('loginForm').classList.remove('active');
            document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('selected'));
        }
        
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'bi bi-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>