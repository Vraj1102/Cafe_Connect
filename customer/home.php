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
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        body { padding-top: 85px; }
        .welcome-section {
            background: linear-gradient(135deg, var(--cc-coffee-brown) 0%, var(--cc-caramel) 50%, var(--cc-caramel-light) 100%);
            color: white;
            padding: 3rem 0;
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
            <p class="lead mb-4" style="color: var(--cc-deep-espresso);">Ready to discover amazing food from your favorite cafes?</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="cc-card text-center">
                    <div class="card-body">
                        <i class="bi bi-shop" style="font-size: 2rem; color: var(--cc-coffee-brown);"></i>
                        <h5 class="mt-2 cc-text-espresso">Available Cafes</h5>
                        <h3 class="cc-text-coffee">
                            <?php
                            $shop_count = $mysqli->query("SELECT COUNT(*) as count FROM shop WHERE s_status = 1")->fetch_array();
                            echo $shop_count['count'];
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cc-card text-center">
                    <div class="card-body">
                        <i class="bi bi-cup-hot" style="font-size: 2rem; color: var(--cc-caramel);"></i>
                        <h5 class="mt-2 cc-text-espresso">Menu Items</h5>
                        <h3 class="cc-text-caramel">
                            <?php
                            $food_count = $mysqli->query("SELECT COUNT(*) as count FROM food WHERE f_todayavail = 1 OR f_preorderavail = 1")->fetch_array();
                            echo $food_count['count'];
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cc-card text-center">
                    <div class="card-body">
                        <i class="bi bi-clock-history" style="font-size: 2rem; color: var(--cc-fresh-green);"></i>
                        <h5 class="mt-2 cc-text-espresso">Your Orders</h5>
                        <h3 class="cc-text-green">
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
    <div class="cc-bg-latte py-5">
        <div class="container">
            <h2 class="text-center mb-2 cc-text-coffee"><i class="bi bi-fire" style="color: var(--cc-caramel);"></i> Trending Right Now</h2>
            <p class="text-center text-muted mb-4">Most loved items by our community</p>
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
                    <div class="cc-card position-relative">
                        <span class="cc-badge cc-badge-trending" style="position: absolute; top: 12px; right: 12px; z-index: 10;">
                            <i class="bi bi-fire"></i> Hot
                        </span>
                        <img src="<?= is_null($item['f_pic']) ? '/CafeConnect/assets/img/default.jpg' : '/CafeConnect/assets/img/'.$item['f_pic'] ?>" 
                             class="cc-card-image" alt="<?= $item['f_name'] ?>">
                        <div class="p-3">
                            <h5 class="cc-text-espresso mb-2"><?= htmlspecialchars($item['f_name']) ?></h5>
                            <p class="text-muted small mb-2"><i class="bi bi-shop"></i> <?= htmlspecialchars($item['s_name']) ?></p>
                            <p class="fw-bold cc-text-coffee mb-2"><?= $item['f_price'] ?> Rs.</p>
                            <a href="/CafeConnect/customer/shop_menu.php?s_id=<?= $item['s_id'] ?>" class="btn-cc-primary w-100 text-center d-block">Order Now</a>
                        </div>
                    </div>
                </div>
                <?php }} ?>
            </div>
        </div>
    </div>

    <!-- Available Shops Section -->
    <div class="cc-bg-cream py-5">
        <div class="container">
        <h2 class="text-center mb-2 cc-text-coffee"><i class="bi bi-shop"></i> Browse Our Cafes</h2>
        <p class="text-center text-muted mb-4">Find your perfect coffee spot</p>

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
                <a href="/CafeConnect/customer/shop_menu.php?s_id=<?= $row["s_id"] ?>" class="text-decoration-none">
                    <div class="cc-card">
                        <img <?php
                            if(is_null($row["s_pic"])){echo "src='/CafeConnect/assets/img/default.jpg'";}
                            else{echo "src=\"/CafeConnect/assets/img/{$row['s_pic']}\"";}
                        ?> class="cc-card-image" alt="<?= htmlspecialchars($row["s_name"]) ?>">
                        <div class="p-3">
                            <h4 class="cc-text-espresso mb-2"><?= htmlspecialchars($row["s_name"]) ?></h4>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-clock"></i> 
                                <?= date('H:i', strtotime($row["s_openhour"])) . ' - ' . date('H:i', strtotime($row["s_closehour"])) ?>
                            </p>
                            <div class="mb-3">
                                <?php if($row["s_status"] == 1): ?>
                                    <span class="cc-badge cc-badge-open">Open Now</span>
                                <?php else: ?>
                                    <span class="cc-badge cc-badge-closed">Closed</span>
                                <?php endif; ?>
                                
                                <?php if($row["s_preorderstatus"] == 1): ?>
                                    <span class="cc-badge cc-badge-preorder">Pre-order Available</span>
                                <?php endif; ?>
                            </div>
                            <div class="text-center">
                                <span class="btn-cc-primary w-100 d-block">View Menu</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php }} ?>
        </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('../includes/footer_customer.php'); ?>

</body>
</html>