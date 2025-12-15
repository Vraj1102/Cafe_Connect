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
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <title>Edit Customer | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="cc-text-coffee mb-4"><i class="bi bi-person-gear"></i> Edit Customer</h2>

        <?php
        $cid = $_GET["c_id"];
        $query = "SELECT * FROM customer WHERE c_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_array();
        ?>

        <form method="POST" action="admin_customer_update.php" class="mt-4">
            <input type="hidden" name="c_id" value="<?= $cid ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($customer['c_username']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($customer['c_email']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" value="<?= htmlspecialchars($customer['c_firstname']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" value="<?= htmlspecialchars($customer['c_lastname']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="gender" required>
                            <option value="M" <?= $customer['c_gender'] == 'M' ? 'selected' : '' ?>>Male</option>
                            <option value="F" <?= $customer['c_gender'] == 'F' ? 'selected' : '' ?>>Female</option>
                            <option value="N" <?= $customer['c_gender'] == 'N' ? 'selected' : '' ?>>Others</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Customer Type</label>
                        <select class="form-select" name="type" required>
                            <option value="STD" <?= $customer['c_type'] == 'STD' ? 'selected' : '' ?>>Student</option>
                            <option value="INS" <?= $customer['c_type'] == 'INS' ? 'selected' : '' ?>>Instructor</option>
                            <option value="STF" <?= $customer['c_type'] == 'STF' ? 'selected' : '' ?>>Staff</option>
                            <option value="GUE" <?= $customer['c_type'] == 'GUE' ? 'selected' : '' ?>>Guest</option>
                            <option value="ADM" <?= $customer['c_type'] == 'ADM' ? 'selected' : '' ?>>Admin</option>
                            <option value="OTH" <?= $customer['c_type'] == 'OTH' ? 'selected' : '' ?>>Others</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn-cc-primary">Update Customer</button>
                <a href="admin_customer_detail.php?c_id=<?= $cid ?>" class="btn-cc-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>