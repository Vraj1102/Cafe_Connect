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
    <title>Shop Details | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-shop"></i> Shop Details</h2>

        <?php
        if (!isset($_GET["s_id"]) || !is_numeric($_GET["s_id"])) {
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
        ?>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title"><?= htmlspecialchars($shop['s_name']) ?></h5>
                        <dl class="row">
                            <dt class="col-sm-3">Username:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($shop['s_username']) ?></dd>
                            
                            <dt class="col-sm-3">Location:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($shop['s_location']) ?></dd>
                            
                            <dt class="col-sm-3">Email:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($shop['s_email']) ?></dd>
                            
                            <dt class="col-sm-3">Phone:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($shop['s_phoneno']) ?></dd>
                            
                            <dt class="col-sm-3">Open Hours:</dt>
                            <dd class="col-sm-9"><?= $shop['s_openhour'] ?> - <?= $shop['s_closehour'] ?></dd>
                            
                            <dt class="col-sm-3">Status:</dt>
                            <dd class="col-sm-9">
                                <?php if($shop['s_status'] == 1): ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </dd>
                            
                            <dt class="col-sm-3">Pre-order:</dt>
                            <dd class="col-sm-9">
                                <?php if(isset($shop['s_preorderstatus']) && $shop['s_preorderstatus'] == 1): ?>
                                    <span class="badge bg-info">Available</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Not Available</span>
                                <?php endif; ?>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <?php if(!empty($shop) && !empty($shop['s_pic'])): ?>
                            <img src="/CafeConnect/assets/img/<?= $shop['s_pic'] ?>" class="img-fluid rounded" alt="Shop Image">
                        <?php else: ?>
                            <img src="/CafeConnect/assets/img/default.jpg" class="img-fluid rounded" alt="Default Image">
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="admin_shop_edit.php?s_id=<?= $s_id ?>" class="btn btn-primary">Edit Shop</a>
                    <a href="admin_shop_list.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>