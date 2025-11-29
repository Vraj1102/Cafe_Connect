<?php
session_start();
require_once '../config/conn_db.php';

// Check if user is logged in
if (!isset($_SESSION['cid'])) {
    header("Location: /CafeConnect/auth_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <style>
        body { padding-top: 85px; }
        .welcome-section {
            background: linear-gradient(135deg, #8B4513 0%, #D2691E 50%, #CD853F 100%);
            color: white;
            padding: 3rem 0;
        }
        .feature-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .trending-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .rounded-25 {
            border-radius: 15px;
        }
    </style>
    <title>CafeConnect - Your Dashboard</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include('../includes/nav_header.php')?>

    <!-- Welcome Section -->
    <div class="welcome-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Welcome back, <?= htmlspecialchars($_SESSION['firstname']) ?>!</h1>
            <p class="lead mb-4">Ready to discover amazing food from your favorite cafes?</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-shop text-primary" style="font-size: 2rem;"></i>
                        <h5 class="mt-2">Available Cafes</h5>
                        <h3 class="text-primary">
                            <?php
                            $shop_count = $mysqli->query("SELECT COUNT(*) as count FROM shop WHERE s_status = 1")->fetch_array();
                            echo $shop_count['count'];
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-cup-hot text-warning" style="font-size: 2rem;"></i>
                        <h5 class="mt-2">Menu Items</h5>
                        <h3 class="text-warning">
                            <?php
                            $food_count = $mysqli->query("SELECT COUNT(*) as count FROM food WHERE f_todayavail = 1 OR f_preorderavail = 1")->fetch_array();
                            echo $food_count['count'];
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <i class="bi bi-clock-history text-success" style="font-size: 2rem;"></i>
                        <h5 class="mt-2">Your Orders</h5>
                        <h3 class="text-success">
                            <?php
                            $order_count = $mysqli->query("SELECT COUNT(*) as count FROM order_header WHERE c_id = {$_SESSION['cid']}")->fetch_array();
                            echo $order_count['count'];
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trending Items Section -->
    <div class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4"><i class="bi bi-fire text-danger"></i> Trending Right Now</h2>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <?php
                $trending_query = "SELECT f.f_id, f.s_id, f.f_name, f.f_price, f.f_pic, s.s_name, COUNT(ord.f_id) as order_count
                    FROM food f 
                    INNER JOIN shop s ON f.s_id = s.s_id
                    LEFT JOIN order_detail ord ON f.f_id = ord.f_id
                    WHERE f.f_todayavail = 1 OR f.f_preorderavail = 1
                    GROUP BY f.f_id
                    ORDER BY order_count DESC
                    LIMIT 4";
                $trending_result = $mysqli->query($trending_query);
                if($trending_result && $trending_result->num_rows > 0){
                    while($item = $trending_result->fetch_array()){
                ?>
                <div class="col">
                    <div class="card feature-card border-0 shadow position-relative">
                        <span class="trending-badge"><i class="bi bi-fire"></i> Hot</span>
                        <img src="<?= is_null($item['f_pic']) ? '/CafeConnect/assets/img/default.jpg' : '/CafeConnect/assets/img/'.$item['f_pic'] ?>" 
                             class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?= $item['f_name'] ?>">
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($item['f_name']) ?></h6>
                            <p class="text-muted small mb-1">From: <?= htmlspecialchars($item['s_name']) ?></p>
                            <p class="card-text fw-bold text-primary mb-2"><?= $item['f_price'] ?> Rs.</p>
                            <a href="/CafeConnect/customer/shop_menu.php?s_id=<?= $item['s_id'] ?>" class="btn btn-sm btn-primary w-100">Order Now</a>
                        </div>
                    </div>
                </div>
                <?php }} ?>
            </div>
        </div>
    </div>

    <!-- Available Shops Section -->
    <div class="container py-5">
        <h2 class="text-center mb-4">
            <i class="bi bi-shop"></i> Browse Our Cafes
        </h2>

        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4">
            <?php
            $query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus,s_pic FROM shop
            WHERE (s_preorderstatus = 1) OR (s_preorderstatus = 0 AND (CURTIME() BETWEEN s_openhour AND s_closehour))
            ORDER BY s_name";
            $result = $mysqli->query($query);
            if($result->num_rows > 0){
                while($row = $result->fetch_array()){
            ?>
            <div class="col">
                <a href="/CafeConnect/customer/shop_menu.php?s_id=<?= $row["s_id"] ?>" class="text-decoration-none text-dark">
                    <div class="card rounded-25 feature-card">
                        <img <?php
                            if(is_null($row["s_pic"])){echo "src='/CafeConnect/assets/img/default.jpg'";}
                            else{echo "src=\"/CafeConnect/assets/img/{$row['s_pic']}\"";}
                        ?> style="width:100%; height:175px; object-fit:cover;"
                            class="card-img-top rounded-25 img-fluid" alt="<?= htmlspecialchars($row["s_name"]) ?>">
                        <div class="card-body">
                            <h4 class="card-title"><?= htmlspecialchars($row["s_name"]) ?></h4>
                            <p class="card-text text-muted">
                                <i class="bi bi-clock"></i> 
                                <?= date('H:i', strtotime($row["s_openhour"])) . ' - ' . date('H:i', strtotime($row["s_closehour"])) ?>
                            </p>
                            <p class="card-text">
                                <?php if($row["s_status"] == 1): ?>
                                    <span class="badge bg-success">Open Now</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Closed</span>
                                <?php endif; ?>
                                
                                <?php if($row["s_preorderstatus"] == 1): ?>
                                    <span class="badge bg-warning text-dark">Pre-order Available</span>
                                <?php endif; ?>
                            </p>
                            <div class="text-center mt-3">
                                <span class="btn btn-outline-primary w-100">View Menu</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php }} ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../includes/footer_customer.php'); ?>

</body>
</html>