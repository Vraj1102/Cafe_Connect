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
    <link href="assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        body { padding-top: 76px; }
        .hero-section {
            background: linear-gradient(rgba(44,24,16,0.5), rgba(111,78,55,0.7)), url('assets/img/landing_homepage.png') center/cover;
            background-attachment: fixed;
            position: relative;
            color: white;
            padding: 8rem 0;
            min-height: 95vh;
            display: flex;
            align-items: center;
        }
        .hero-logo { 
            filter: drop-shadow(0 8px 16px rgba(0,0,0,0.4));
            animation: fadeInUp 1.2s ease-out;
        }
        .hero-content { animation: fadeInUp 1s ease-out 0.3s both; }
        .hero-buttons { animation: fadeInUp 1s ease-out 0.6s both; }
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        .shiny-text {
            background: linear-gradient(90deg, #FFD700 0%, #FFF 25%, #FFD700 50%, #FFA500 75%, #FFD700 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
            filter: drop-shadow(0 0 20px rgba(255,215,0,0.8)) drop-shadow(0 0 40px rgba(255,165,0,0.6));
        }
    </style>
    <title>Welcome To CafeConnect!!!</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include('includes/nav_header.php')?>

    <!-- Hero Section -->
    <div class="hero-section text-center">
        <div class="container">
            <img src="assets/img/landing_logo.png" alt="CafeConnect Logo" class="hero-logo mb-4" style="max-height: 180px;">
            <div class="hero-content">
                <h1 class="display-1 fw-bold mb-3" style="color: #F4E4C1; text-shadow: 2px 4px 8px rgba(0,0,0,0.5);">Welcome to CafeConnect</h1>
                <p class="display-6 mb-4 shiny-text">Brewing Connections</p>
                <p class="lead mb-4 fs-4" style="text-shadow: 1px 2px 4px rgba(0,0,0,0.4);">Discover exceptional coffee experiences and connect with your favorite local cafes</p>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="container py-5 my-5">
        <div class="row align-items-center">
            <div class="col-md-6 cc-animate-slide-in">
                <h2 class="display-5 mb-4 cc-text-coffee">About CafeConnect</h2>
                <p class="lead cc-text-espresso">Connecting you with the finest cafes and restaurants in your area.</p>
                <p class="mb-4">At CafeConnect, we believe in quality, convenience, and excellent service. Our platform features a wide variety of cafes and restaurants, offering everything from fresh coffee to tasty meals, all available for easy online ordering.</p>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="bi bi-check-circle-fill cc-text-green me-2"></i> Fresh ingredients daily</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill cc-text-green me-2"></i> Quick online ordering</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill cc-text-green me-2"></i> Pre-order available</li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill cc-text-green me-2"></i> Multiple shop locations</li>
                </ul>
            </div>
            <div class="col-md-6 cc-animate-fade-in">
                <img src="assets/img/Coffee Shop banner.jpg" class="img-fluid cc-rounded-lg cc-shadow-lg" alt="Cafe">
            </div>
        </div>
    </div>

    <!-- Trending Items Section (carousel style) -->
    <div class="cc-bg-latte py-5">
        <div class="container py-4">
            <div class="d-flex align-items-center mb-3">
                <h2 class="me-auto cc-text-coffee"><i class="bi bi-fire" style="color: var(--cc-caramel);"></i> Trending Now</h2>
                <div>
                    <button id="trendPrev" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-chevron-left"></i></button>
                    <button id="trendNext" class="btn btn-sm btn-outline-secondary"><i class="bi bi-chevron-right"></i></button>
                </div>
            </div>
            <p class="text-center text-muted mb-4">Most loved items by our community</p>

            <div id="trendingContainer" style="display:flex; gap:1rem; overflow-x:auto; scroll-behavior:smooth; padding-bottom:8px;">
                <?php
                // Use f_todayavail column (schema uses f_todayavail) instead of non-existent f_status
                $trending_query = "SELECT f.f_id, f.f_name, f.f_price, f.f_pic, s.s_name, COUNT(ord.f_id) as order_count
                    FROM food f
                    INNER JOIN shop s ON f.s_id = s.s_id
                    LEFT JOIN order_detail ord ON f.f_id = ord.f_id
                    WHERE f.f_todayavail = 1
                    GROUP BY f.f_id
                    ORDER BY order_count DESC
                    LIMIT 5";
                $trending_result = $mysqli->query($trending_query);
                if($trending_result && $trending_result->num_rows > 0){
                    while($item = $trending_result->fetch_assoc()){
                ?>
                <div class="cc-card" style="min-width:220px; flex:0 0 auto; max-width:260px;">
                    <div style="position:relative;">
                        <span class="cc-badge cc-badge-trending" style="position: absolute; top: 12px; right: 12px; z-index: 10;"><i class="bi bi-fire"></i> Hot</span>
                        <img src="<?= empty($item['f_pic']) ? 'assets/img/default.jpg' : 'assets/img/'.$item['f_pic'] ?>" class="cc-card-image" alt="<?= htmlspecialchars($item['f_name']) ?>" style="height:140px; object-fit:cover;">
                    </div>
                    <div class="p-3">
                        <h6 class="cc-text-espresso mb-1" style="min-height:2.4rem"><?= htmlspecialchars($item['f_name']) ?></h6>
                        <p class="text-muted small mb-2"><i class="bi bi-shop"></i> <?= htmlspecialchars($item['s_name']) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold cc-text-coffee"><?= number_format($item['f_price'],2) ?> Rs.</div>
                            <a href="customer/food_item.php?f_id=<?= $item['f_id'] ?>" class="btn btn-sm btn-cc-primary">Order</a>
                        </div>
                    </div>
                </div>
                <?php }
                } else { ?>
                <div class="text-muted">No trending items yet.</div>
                <?php } ?>
            </div>
            <script>
                (function(){
                    const cont = document.getElementById('trendingContainer');
                    document.getElementById('trendPrev').addEventListener('click', ()=> cont.scrollBy({left:-260, behavior:'smooth'}));
                    document.getElementById('trendNext').addEventListener('click', ()=> cont.scrollBy({left:260, behavior:'smooth'}));
                })();
            </script>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5 my-5">
        <h2 class="text-center mb-2 cc-text-coffee">Why Choose CafeConnect?</h2>
        <p class="text-center text-muted mb-5">Experience the difference with our premium service</p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="cc-card text-center cc-spacing-lg">
                    <i class="bi bi-clock-history" style="font-size: 3.5rem; color: var(--cc-coffee-brown);"></i>
                    <h4 class="mt-4 mb-3 cc-text-espresso">Quick Service</h4>
                    <p class="text-muted">Fast preparation and pickup times for your convenience</p>
                </div>
            </div>
            <div class="col">
                <div class="cc-card text-center cc-spacing-lg">
                    <i class="bi bi-star-fill" style="font-size: 3.5rem; color: var(--cc-gold);"></i>
                    <h4 class="mt-4 mb-3 cc-text-espresso">Quality Food</h4>
                    <p class="text-muted">Fresh ingredients and authentic recipes every day</p>
                </div>
            </div>
            <div class="col">
                <div class="cc-card text-center cc-spacing-lg">
                    <i class="bi bi-phone" style="font-size: 3.5rem; color: var(--cc-fresh-green);"></i>
                    <h4 class="mt-4 mb-3 cc-text-espresso">Easy Ordering</h4>
                    <p class="text-muted">Simple online ordering system with pre-order options</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Shops Section -->
    <div class="cc-bg-cream py-5">
        <div class="container py-4">
            <h2 class="text-center mb-2 cc-text-coffee"><i class="bi bi-shop"></i> Browse Our Cafes</h2>
            <p class="text-center text-muted mb-5">Find your perfect coffee spot</p>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            <?php
            $query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus,s_pic FROM shop
            WHERE (s_preorderstatus = 1) OR (s_preorderstatus = 0 AND (CURTIME() BETWEEN s_openhour AND s_closehour))";
            $result = $mysqli->query($query);
            if($result && $result->num_rows > 0){
            while($row = $result->fetch_array()){
        ?>
            <div class="col">
                <a href="<?php echo "customer/shop_menu.php?s_id=".$row["s_id"]?>" class="text-decoration-none">
                    <div class="cc-card">
                        <img <?php
                            if(is_null($row["s_pic"])){echo "src='assets/img/default.jpg'";}
                            else{echo "src=\"assets/img/{$row['s_pic']}\"";}
                        ?> class="cc-card-image" alt="<?php echo htmlspecialchars($row["s_name"])?>">
                        <div class="p-4">
                            <h4 class="cc-text-espresso mb-3"><?php echo htmlspecialchars($row["s_name"])?></h4>
                            <p class="text-muted mb-3">
                                <i class="bi bi-clock"></i> 
                                <?php echo date('H:i', strtotime($row["s_openhour"])) . ' - ' . date('H:i', strtotime($row["s_closehour"])); ?>
                            </p>
                            <div class="mb-3">
                                <?php if($row["s_status"] == 1): ?>
                                    <span class="cc-badge cc-badge-open">Open Now</span>
                                <?php else: ?>
                                    <span class="cc-badge cc-badge-closed">Closed</span>
                                <?php endif; ?>
                                
                                <?php if($row["s_preorderstatus"] == 1): ?>
                                    <span class="cc-badge cc-badge-preorder ms-2">Pre-order</span>
                                <?php endif; ?>
                            </div>
                            <button class="btn-cc-primary btn-sm w-100"><i class="bi bi-arrow-right"></i> View Menu</button>
                        </div>
                    </div>
                </a>
            </div>
            <?php }} ?>
            </div>
        </div>
    </div>

    <!-- Impressive Footer -->
    <footer class="text-light mt-auto" style="background: linear-gradient(135deg, #2C1810 0%, #8B4513 50%, #D2691E 100%);">
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="assets/img/landing_logo.png" width="50" class="me-3" alt="CafeConnect">
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
                        <li class="mb-2"><a href="index.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> Home</a></li>
                        <li class="mb-2"><a href="customer/shop_list.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> Our Cafes</a></li>
                        <li class="mb-2"><a href="about.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i> About Us</a></li>
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
                    <a href="about.php" class="text-light text-decoration-none">About Us</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>