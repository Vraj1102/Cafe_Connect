<?php
session_start();
require_once 'config/conn_db.php';

// Check if user is logged in (optional)
$isAuthenticated = isset($_SESSION['cid']);
$userRole = $_SESSION['utype'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        html { height: 100%; }
        body { padding-top: 76px; }
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(139,69,19,0.6)), url('/CafeConnect/assets/img/landing_homepage.png') center/cover;
            position: relative;
            color: white;
            padding: 6rem 0;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }
        .hero-logo {
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
            animation: fadeInUp 1s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hero-section .container {
            position: relative;
            z-index: 1;
        }
        .feature-card {
            transition: transform 0.3s;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-10px);
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
    <title>Welcome To CafeConnect!!!</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include('includes/nav_header.php')?>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container" style="margin-top: -80px;">
            <img src="/CafeConnect/assets/img/landing_logo.png" alt="CafeConnect Logo" class="hero-logo mb-4" style="max-height: 200px;">
            <h1 class="display-2 fw-bold mb-3 text-shadow">Welcome to CafeConnect</h1>
            <p class="display-6 mb-3 text-warning fw-bold fst-italic">"Brewing Connections"</p>
            <p class="lead mb-2 fs-4">Discover exceptional coffee experiences and connect with your favorite local cafes</p>
            <?php if ($isAuthenticated): ?>
                <span class="badge bg-success fs-6">Logged in as <?= ucfirst($userRole ?? 'User') ?></span>
            <?php else: ?>
                <a href="/CafeConnect/auth_login.php" class="btn btn-light btn-lg me-2">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
                <a href="/CafeConnect/customer/cust_regist.php" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-person-plus"></i> Sign Up
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- About Section -->
    <div class="container py-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <h2 class="display-5 mb-3">About CafeConnect</h2>
                <p class="lead">Connecting you with the finest cafes and restaurants in your area.</p>
                <p>At CafeConnect, we believe in quality, convenience, and excellent service. Our platform features a wide variety of cafes and restaurants, offering everything from fresh coffee to tasty meals, all available for easy online ordering.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle-fill text-success"></i> Fresh ingredients daily</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Quick online ordering</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Pre-order available</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Multiple shop locations</li>
                </ul>
            </div>
            <div class="col-md-6">
                <img src="/CafeConnect/assets/img/Coffee Shop banner.jpg" class="img-fluid rounded shadow" alt="Cafe">
            </div>
        </div>
    </div>

    <!-- Trending Items Section -->
    <div class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4"><i class="bi bi-fire text-danger"></i> Trending Items</h2>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php
                // Get top 4 trending items (most ordered)
                $trending_query = "SELECT f.f_id, f.f_name, f.f_price, f.f_pic, s.s_name, COUNT(ord.f_id) as order_count
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
                        <span class="trending-badge"><i class="bi bi-fire"></i> Trending</span>
                        <img src="<?= is_null($item['f_pic']) ? '/CafeConnect/assets/img/default.jpg' : '/CafeConnect/assets/img/'.$item['f_pic'] ?>" 
                             class="card-img-top" style="height: 150px; object-fit: cover;" alt="<?= $item['f_name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item['f_name'] ?></h5>
                            <p class="text-muted small">From: <?= $item['s_name'] ?></p>
                            <p class="card-text fw-bold text-primary"><?= $item['f_price'] ?> Rs.</p>
                        </div>
                    </div>
                </div>
                <?php }} ?>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <h2 class="text-center mb-5">Why Choose CafeConnect?</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card feature-card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <i class="bi bi-clock-history text-primary" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Quick Service</h4>
                        <p class="text-muted">Fast preparation and pickup times for your convenience</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card feature-card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <i class="bi bi-star-fill text-warning" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Quality Food</h4>
                        <p class="text-muted">Fresh ingredients and authentic recipes every day</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card feature-card text-center border-0 shadow-sm">
                    <div class="card-body p-4">
                        <i class="bi bi-phone text-success" style="font-size: 3rem;"></i>
                        <h4 class="mt-3">Easy Ordering</h4>
                        <p class="text-muted">Simple online ordering system with pre-order options</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Shops Section -->
    <div class="container p-5" id="recommended-shop">
        <h2 class="text-center mb-4">
            <i class="bi bi-shop"></i> Our Shops
        </h2>

        <!-- GRID SHOP SELECTION -->
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-3">

            <?php
            $query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus,s_pic FROM shop
            WHERE (s_preorderstatus = 1) OR (s_preorderstatus = 0 AND (CURTIME() BETWEEN s_openhour AND s_closehour));";
            $result = $mysqli -> query($query);
            if($result -> num_rows > 0){
            while($row = $result -> fetch_array()){
        ?>
            <!-- GRID EACH SHOP -->
            <div class="col">
                <a href="<?php echo "/CafeConnect/customer/shop_menu.php?s_id=".$row["s_id"]?>" class="text-decoration-none text-dark">
                    <div class="card rounded-25">
                        <img <?php
                            if(is_null($row["s_pic"])){echo "src='/CafeConnect/assets/img/default.jpg'";}
                            else{echo "src=\"/CafeConnect/assets/img/{$row['s_pic']}\"";}
                        ?> style="width:100%; height:175px; object-fit:cover;"
                            class="card-img-top rounded-25 img-fluid" alt="<?php echo $row["s_name"]?>">
                        <div class="card-body">
                            <h4 name="shop-name" class="card-title"><?php echo $row["s_name"]?></h4>
                            <p class="card-text text-muted">
                                <i class="bi bi-clock"></i> 
                                <?php echo date('H:i', strtotime($row["s_openhour"])) . ' - ' . date('H:i', strtotime($row["s_closehour"])); ?>
                            </p>
                            <p class="card-text">
                                <?php if($row["s_status"] == 1): ?>
                                    <span class="badge bg-success">Open Now</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Closed</span>
                                <?php endif; ?>
                                
                                <?php if($row["s_preorderstatus"] == 1): ?>
                                    <span class="badge bg-info">Pre-order Available</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <?php }} ?>
        </div>
    </div>

    <!-- Impressive Footer -->
    <footer class="text-light mt-auto" style="background: linear-gradient(135deg, #2C1810 0%, #8B4513 50%, #D2691E 100%);">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="/CafeConnect/assets/img/Main Logo 2.jpeg" width="50" class="me-3 rounded-circle" alt="CafeConnect">
                        <div>
                            <h4 class="mb-0 text-white fw-bold">CafeConnect</h4>
                            <small class="text-light fst-italic">"Brewing Connections"</small>
                        </div>
                    </div>
                    <p class="text-light mb-3">Your premier destination for exceptional coffee experiences and delicious food, connecting communities one cup at a time.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-light fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-light fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-light fs-4"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/CafeConnect/index.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> Home</a></li>
                        <li class="mb-2"><a href="/CafeConnect/customer/shop_list.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> Our Cafes</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3">Services</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-cup-hot"></i> Fresh Coffee</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-basket"></i> Online Ordering</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-clock"></i> Pre-Orders</a></li>
                        <li class="mb-2"><a href="#" class="text-light text-decoration-none"><i class="bi bi-truck"></i> Quick Pickup</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-3">Contact Info</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-light"><i class="bi bi-geo-alt"></i> Multiple Locations</li>
                        <li class="mb-2 text-light"><i class="bi bi-telephone"></i> +1 (555) 123-CAFE</li>
                        <li class="mb-2 text-light"><i class="bi bi-envelope"></i> hello@cafeconnect.com</li>
                        <li class="mb-2 text-light"><i class="bi bi-clock"></i> Open Daily 7AM - 9PM</li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 border-light">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-light">&copy; 2024 CafeConnect. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light text-decoration-none me-3">Privacy Policy</a>
                    <a href="#" class="text-light text-decoration-none me-3">Terms of Service</a>
                    <a href="#" class="text-light text-decoration-none">Support</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>