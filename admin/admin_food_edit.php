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
    <title>Edit Food | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-card-list"></i> Edit Food Item</h2>

        <?php
        $f_id = $_GET["f_id"];
        $query = "SELECT f.*, s.s_name FROM food f INNER JOIN shop s ON f.s_id = s.s_id WHERE f.f_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $f_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $food = $result->fetch_array();
        ?>

        <form method="POST" action="admin_food_update.php" class="mt-4">
            <input type="hidden" name="f_id" value="<?= $f_id ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Food Name</label>
                        <input type="text" class="form-control" name="f_name" value="<?= htmlspecialchars($food['f_name']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Price (Rs.)</label>
                        <input type="number" step="0.01" class="form-control" name="f_price" value="<?= $food['f_price'] ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Shop</label>
                        <select class="form-select" name="s_id" required>
                            <?php
                            $shops_query = "SELECT s_id, s_name FROM shop ORDER BY s_name";
                            $shops_result = $mysqli->query($shops_query);
                            while($shop = $shops_result->fetch_array()){
                            ?>
                            <option value="<?= $shop['s_id'] ?>" <?= $shop['s_id'] == $food['s_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($shop['s_name']) ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Available Today</label>
                        <select class="form-select" name="f_todayavail" required>
                            <option value="1" <?= $food['f_todayavail'] == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= $food['f_todayavail'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pre-order Available</label>
                        <select class="form-select" name="f_preorderavail" required>
                            <option value="1" <?= $food['f_preorderavail'] == 1 ? 'selected' : '' ?>>Yes</option>
                            <option value="0" <?= $food['f_preorderavail'] == 0 ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Food Item</button>
                <a href="admin_food_detail.php?f_id=<?= $f_id ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>