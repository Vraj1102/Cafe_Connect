<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <?php 
        session_start(); 
        include("../config/conn_db.php"); 
        include('../includes/head.php');
        if(!isset($_SESSION["cid"])){
            header("location: ../auth_login.php");
            exit(1);
        }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <link href="../assets/css/customer-home.css" rel="stylesheet">
    <style>body { padding-top: 85px; }</style>
    <title>Customer Dashboard | CafeConnect</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include('../includes/nav_header.php')?>

    <div class="container px-0 flex-grow-1">
        <!-- Hero -->
        <div class="hero-section text-white text-center" style="background-image: url('/CafeConnect/assets/img/landing_homepage.png');">
            <div class="container">
                <h1 class="display-4 fw-bold mb-2">Welcome back, <?= htmlspecialchars($_SESSION['firstname']) ?>!</h1>
                <p class="lead mb-3">Discover trending favorites and quick picks from local cafes — order ahead and skip the line.</p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="shop_list.php" class="btn btn-lg btn-cc-primary">Order Now</a>
                    <a href="cust_order_history.php" class="btn btn-lg btn-outline-light">My Orders</a>
                </div>
            </div>
        </div>

        <div class="container p-4">
        <h2 class="cc-text-coffee mb-4 mt-4"><i class="bi bi-house-door"></i> Quick Actions</h2>
        
        <!-- Quick Actions -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="cc-card text-center">
                    <i class="bi bi-shop" style="font-size: 3rem; color: var(--cc-coffee-brown);"></i>
                    <h4 class="mt-3 mb-3 cc-text-espresso">Browse Cafes</h4>
                    <p class="text-muted mb-3">Discover amazing cafes and restaurants</p>
                    <a href="shop_list.php" class="btn-cc-primary">View All Cafes</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cc-card text-center">
                    <i class="bi bi-cart" style="font-size: 3rem; color: var(--cc-fresh-green);"></i>
                    <h4 class="mt-3 mb-3 cc-text-espresso">My Cart</h4>
                    <p class="text-muted mb-3">Review items in your cart</p>
                    <a href="cust_cart.php" class="btn-cc-success">View Cart</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cc-card text-center">
                    <i class="bi bi-clock-history" style="font-size: 3rem; color: var(--cc-caramel);"></i>
                    <h4 class="mt-3 mb-3 cc-text-espresso">Order History</h4>
                    <p class="text-muted mb-3">Track your past orders</p>
                    <a href="cust_order_history.php" class="btn-cc-warning">View Orders</a>
                </div>
            </div>
        </div>

        <!-- Trending Now -->
        <h3 class="cc-text-coffee mb-3"><i class="bi bi-fire"></i> Trending Now</h3>
        <div id="custTrending" style="display:flex; gap:1rem; overflow-x:auto; padding-bottom:8px;">
            <?php
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
                    <img src="<?= empty($item['f_pic']) ? '../assets/img/default.jpg' : '../assets/img/'.$item['f_pic'] ?>" class="cc-card-image" alt="<?= htmlspecialchars($item['f_name']) ?>" style="height:140px; object-fit:cover;">
                </div>
                <div class="p-3">
                    <h6 class="cc-text-espresso mb-1" style="min-height:2.4rem"><?= htmlspecialchars($item['f_name']) ?></h6>
                    <p class="text-muted small mb-2"><i class="bi bi-shop"></i> <?= htmlspecialchars($item['s_name']) ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold cc-text-coffee"><?= number_format($item['f_price'],2) ?> Rs.</div>
                        <a href="food_item.php?f_id=<?= $item['f_id'] ?>" class="btn btn-sm btn-cc-primary">Order</a>
                    </div>
                </div>
            </div>
            <?php }
            } else { ?>
            <div class="text-muted">No trending items yet.</div>
            <?php } ?>
        </div>

        <!-- Available Shops -->
        <h3 class="cc-text-coffee mb-4"><i class="bi bi-shop"></i> Available Cafes</h3>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4">
            <?php
            $query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus,s_pic FROM shop
            WHERE (s_preorderstatus = 1) OR (s_preorderstatus = 0 AND (CURTIME() BETWEEN s_openhour AND s_closehour))";
            $result = $mysqli->query($query);
            if($result && $result->num_rows > 0){
                while($row = $result->fetch_array()){
            ?>
            <div class="col">
                <a href="shop_menu.php?s_id=<?= $row['s_id'] ?>" class="text-decoration-none">
                    <div class="cc-card">
                        <img src="<?= is_null($row['s_pic']) ? '../assets/img/default.jpg' : '../assets/img/'.$row['s_pic'] ?>" 
                             class="cc-card-image" alt="<?= htmlspecialchars($row['s_name']) ?>">
                        <div class="p-3">
                            <h4 class="cc-text-espresso mb-2"><?= htmlspecialchars($row['s_name']) ?></h4>
                            <?php 
                                $open = explode(":",$row["s_openhour"]);
                                $close = explode(":",$row["s_closehour"]);
                            ?>
                            <p class="text-muted small mb-2"><i class="bi bi-clock"></i> <?= $open[0].":".$open[1]." - ".$close[0].":".$close[1] ?></p>
                            <div class="mb-3">
                                <?php 
                                    $now = date('H:i:s');
                                    if((($now < $row["s_openhour"])||($now > $row["s_closehour"]))||($row["s_status"]==0)){
                                ?>
                                <span class="cc-badge cc-badge-closed">Closed</span>
                                <?php }else{ ?>
                                <span class="cc-badge cc-badge-open">Open Now</span>
                                <?php }
                                    if($row["s_preorderstatus"]==1){
                                ?>
                                <span class="cc-badge cc-badge-preorder">Pre-order Available</span>
                                <?php } ?>
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
    <div class="mt-5"></div>
    <?php include('../includes/footer_customer.php'); ?>
</body>
</html>