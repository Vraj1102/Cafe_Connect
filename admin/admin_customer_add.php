<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start(); 
    include("../config/conn_db.php"); 
    include('../includes/head.php');
    if($_SESSION["utype"]!="ADMIN"){
        header("location: ../includes/restricted.php");
        exit(1);
    }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <title>Add Customer | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-person-plus"></i> Add New Customer</h2>

        <form method="POST" action="admin_customer_add_process.php" class="mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Username *</label>
                        <input type="text" class="form-control" name="username" minlength="5" maxlength="45" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" name="email" maxlength="100" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control" name="password" minlength="8" maxlength="45" required>
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control" name="confirm_password" minlength="8" maxlength="45" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">First Name *</label>
                        <input type="text" class="form-control" name="firstname" maxlength="45" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Last Name *</label>
                        <input type="text" class="form-control" name="lastname" maxlength="45" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Gender *</label>
                        <select class="form-select" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="N">Others</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Customer Type *</label>
                        <select class="form-select" name="type" required>
                            <option value="">Select Type</option>
                            <option value="STD">Student</option>
                            <option value="INS">Instructor</option>
                            <option value="STF">Staff</option>
                            <option value="GUE">Guest</option>
                            <option value="ADM">Admin</option>
                            <option value="OTH">Others</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Add Customer</button>
                <a href="admin_customer_list.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <?php include('../includes/footer_admin.php'); ?>

    <script>
        // Password confirmation validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const confirm = document.querySelector('input[name="confirm_password"]').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>