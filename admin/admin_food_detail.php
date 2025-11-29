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
    <title>Food Details | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-card-list"></i> Food Details</h2>

        <?php
        $f_id = $_GET["f_id"];
        $query = "SELECT f.*, s.s_name FROM food f INNER JOIN shop s ON f.s_id = s.s_id WHERE f.f_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $f_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $food = $result->fetch_array();
        ?>

        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="card-title"><?= htmlspecialchars($food['f_name']) ?></h5>
                        <dl class="row">
                            <dt class="col-sm-3">Shop:</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($food['s_name']) ?></dd>
                            
                            <dt class="col-sm-3">Price:</dt>
                            <dd class="col-sm-9"><?= $food['f_price'] ?> Rs.</dd>
                            
                            <dt class="col-sm-3">Available Today:</dt>
                            <dd class="col-sm-9">
                                <?php if($food['f_todayavail'] == 1): ?>
                                    <span class="badge bg-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">No</span>
                                <?php endif; ?>
                            </dd>
                            
                            <dt class="col-sm-3">Pre-order Available:</dt>
                            <dd class="col-sm-9">
                                <?php if($food['f_preorderavail'] == 1): ?>
                                    <span class="badge bg-info">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No</span>
                                <?php endif; ?>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <?php if($food['f_pic']): ?>
                            <img src="/CafeConnect/assets/img/<?= $food['f_pic'] ?>" class="img-fluid rounded" alt="Food Image">
                        <?php else: ?>
                            <img src="/CafeConnect/assets/img/default.jpg" class="img-fluid rounded" alt="Default Image">
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="admin_food_edit.php?f_id=<?= $f_id ?>" class="btn btn-primary">Edit Food</a>
                    <a href="admin_food_list.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>