<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        if($_SESSION["utype"]!="shopowner"){
            header("location: ../includes/restricted.php");
            exit(1);
        }
        include("../config/conn_db.php"); 
        include('../includes/head.php');
        $s_id = $_SESSION["sid"];
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <title>Shop Owner Home | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 85px;">
    <?php include('nav_header_shop.php'); ?>

    <div class="d-flex text-center text-white py-3" style="background: linear-gradient(135deg, var(--cc-coffee-brown) 0%, var(--cc-caramel) 50%, var(--cc-caramel-light) 100%);">
        <div class="p-lg-2 mx-auto my-3">
            <h1 class="display-5 fw-normal"><?php echo htmlspecialchars($_SESSION["shopname"])?></h1>
            <p class="lead fw-normal" style="color: var(--cc-deep-espresso);">Welcome to CafeConnect</p>
        </div>
    </div>

    <div class="container p-5" id="shop-dashboard">
        <h2 class="cc-text-coffee mb-4"><i class="bi bi-graph-up"></i> Shop Dashboard <span
                class="small fw-light text-muted"><?php echo date('F j, Y');?></span></h2>

        <!-- SHOP OWNER GRID DASHBOARD -->
        <div class="row row-cols-1 row-cols-lg-2 align-items-stretch g-4 py-3">
            <!-- TODAY ORDER GRID -->
            <div class="col">
                <div class="cc-card" style="border-left: 4px solid var(--cc-fresh-green);">
                    <div class="card-body">
                        <p class="cc-text-espresso mb-3">
                            <i class="bi bi-check-circle" style="color: var(--cc-fresh-green);"></i>&nbsp;&nbsp;Today Completed Order</p>
                        <p class="card-text my-2">
                            <span class="display-5 cc-text-coffee">
                                <?php 
                                    $query = "SELECT COUNT(*) AS cnt_order FROM order_header WHERE s_id = {$s_id} AND DATE(orh_pickuptime) = CURDATE() AND orh_orderstatus = 'FNSH';";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    echo $result["cnt_order"];
                                    ?>
                                Orders
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- END TODAY ORDER GRID -->
            <!-- TODAY REVENUE GRID -->
            <div class="col">
                <div class="cc-card" style="border-left: 4px solid var(--cc-gold);">
                    <div class="card-body">
                        <p class="cc-text-espresso mb-3">
                            <i class="bi bi-coin" style="color: var(--cc-gold);"></i>&nbsp;&nbsp;Today Revenue</p>
                        <p class="card-text my-2">
                            <span class="display-5 cc-text-coffee">
                                <?php 
                                        $query = "SELECT SUM(ord.ord_buyprice*ord.ord_amount) AS revenue FROM order_header orh INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
                                        WHERE orh.s_id = {$s_id} AND DATE(orh.orh_pickuptime) = CURDATE() AND orh.orh_orderstatus = 'FNSH';";
                                        $result = $mysqli -> query($query) -> fetch_array();
                                        if(!is_null($result["revenue"])){echo $result["revenue"];}else{echo "0.00";}
                                    ?>
                                
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- END TODAY REVENUE GRID -->

            <!-- GRID OF ORDER NEEDED TO BE COMPLETE -->
            <div class="col">
                <a href="shop_order_list.php" class="text-decoration-none">
                    <div class="cc-card" style="border-left: 4px solid var(--cc-caramel);">
                        <div class="card-body">
                            <h5 class="cc-text-espresso mb-3">
                                <i class="bi bi-hourglass-split" style="color: var(--cc-caramel);"></i>
                                Remaining Order</h5>
                            <p class="text-muted my-2">
                                <span class="h6 cc-text-coffee">
                                    <?php 
                                    $query = "SELECT COUNT(*) AS cnt_remain FROM order_header WHERE s_id = {$s_id} AND orh_orderstatus NOT LIKE 'FNSH';";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    echo $result["cnt_remain"];
                                ?>
                                </span>
                                orders left to be finished
                            </p>
                            <div class="text-end">
                                <span class="btn-cc-secondary btn-sm">Go to Order List</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF ORDER NEEDED TO BE COMPLETE -->

            <!-- GRID OF MENU -->
            <div class="col">
                <a href="shop_menu_list.php" class="text-decoration-none">
                    <div class="cc-card" style="border-left: 4px solid var(--cc-coffee-brown);">
                        <div class="card-body">
                            <h5 class="cc-text-espresso mb-3">
                                <i class="bi bi-cup-hot" style="color: var(--cc-coffee-brown);"></i>
                                Food Menu</h5>
                            <p class="text-muted my-2">
                                <span class="h6 cc-text-coffee">
                                    <?php
                                    $query = "SELECT COUNT(*) AS cnt_menu FROM food f INNER JOIN shop s ON f.s_id = s.s_id 
                                    WHERE (s.s_status = 1 AND (CURTIME() BETWEEN s.s_openhour AND s.s_closehour) AND f.f_todayavail = 1) OR (s.s_preorderstatus = 1 AND f.f_preorderavail = 1) AND s.s_id = {$s_id};";
                                    $result = $mysqli -> query($query) -> fetch_array();
                                    echo $result["cnt_menu"];
                                ?>
                                </span>
                                Menus available to order
                            </p>
                            <div class="text-end">
                                <span class="btn-cc-secondary btn-sm">Go to Menu List</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF ORDER NEEDED TO BE COMPLETE -->
        </div>
        <!-- END ADMIN GRID DASHBOARD -->
    </div>
    <?php include('../includes/footer_shop.php'); ?>
</body>

</html>