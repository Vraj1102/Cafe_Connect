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
    <link href="../assets/css/main.css" rel="stylesheet">
    <title>Edit Shop | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-shop"></i> Edit Shop</h2>

        <?php
        if (!isset($_GET["s_id"]) || !is_numeric($_GET["s_id"])){
            echo '<div class="alert alert-warning">Missing or invalid shop id.</div>';
            include('../includes/footer_admin.php');
            exit();
        }
        $s_id = (int) $_GET["s_id"];
        $query = "SELECT * FROM shop WHERE s_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $s_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $shop = $result->fetch_array();
        if (!$shop) {
            echo '<div class="alert alert-warning">Shop not found.</div>';
            include('../includes/footer_admin.php');
            exit();
        }
        ?>

        <form method="POST" action="admin_shop_update.php" class="mt-4">
            <input type="hidden" name="s_id" value="<?= $s_id ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Shop Name</label>
                        <input type="text" class="form-control" name="s_name" value="<?= htmlspecialchars($shop['s_name']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="s_location" value="<?= htmlspecialchars($shop['s_location']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="s_email" value="<?= htmlspecialchars($shop['s_email']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="s_phoneno" value="<?= htmlspecialchars($shop['s_phoneno']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Open Hour</label>
                        <input type="time" class="form-control" name="s_openhour" value="<?= $shop['s_openhour'] ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Close Hour</label>
                        <input type="time" class="form-control" name="s_closehour" value="<?= $shop['s_closehour'] ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="s_status" required>
                            <option value="1" <?= $shop['s_status'] == 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= $shop['s_status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pre-order Status</label>
                        <select class="form-select" name="s_preorderstatus" required>
                            <option value="1" <?= (isset($shop['s_preorderstatus']) && $shop['s_preorderstatus'] == 1) ? 'selected' : '' ?>>Available</option>
                            <option value="0" <?= (isset($shop['s_preorderstatus']) && $shop['s_preorderstatus'] == 0) ? 'selected' : '' ?>>Not Available</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Shop</button>
                <a href="admin_shop_detail.php?s_id=<?= $s_id ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>