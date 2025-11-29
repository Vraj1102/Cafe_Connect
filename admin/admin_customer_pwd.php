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
    <title>Change Customer Password | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-key"></i> Change Customer Password</h2>

        <?php
        $cid = $_GET["c_id"];
        $query = "SELECT c_username, c_firstname, c_lastname FROM customer WHERE c_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_array();
        ?>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Customer: <?= htmlspecialchars($customer['c_firstname'] . ' ' . $customer['c_lastname']) ?></h5>
                <p class="card-text">Username: <?= htmlspecialchars($customer['c_username']) ?></p>
                
                <form method="POST" action="admin_customer_pwd_update.php">
                    <input type="hidden" name="c_id" value="<?= $cid ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="new_password" minlength="8" required>
                        <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" name="confirm_password" minlength="8" required>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                        <a href="admin_customer_detail.php?c_id=<?= $cid ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('../includes/footer_admin.php'); ?>

    <script>
        // Password confirmation validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="new_password"]').value;
            const confirm = document.querySelector('input[name="confirm_password"]').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>