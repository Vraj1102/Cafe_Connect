<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start(); include("../config/conn_db.php"); include('../includes/head.php');?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        html { height: 100%; }
        body { padding-top: 85px; }
    </style>
    <title>Shop List | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('../includes/nav_header.php')?>

    <div class="container p-5" id="recommended-shop">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        <h2 class="cc-text-coffee mb-2"><i class="bi bi-shop"></i> Available Cafes</h2>
        <p class="text-muted mb-4">Browse all our partner cafes</p>
        
        <!-- GRID SHOPS SELECTION -->
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-3">

        <?php
            $query = "SELECT s_id,s_name,s_openhour,s_closehour,s_status,s_preorderstatus,s_pic FROM shop
            WHERE (s_preorderstatus = 1) OR (s_preorderstatus = 0 AND (CURTIME() BETWEEN s_openhour AND s_closehour));";
            $result = $mysqli -> query($query);
            if($result -> num_rows > 0){
            while($row = $result -> fetch_array()){
        ?>
            <!-- GRID EACH SHOPS -->
            <div class="col">
                <a href="<?php echo "/CafeConnect/customer/shop_menu.php?s_id=".$row["s_id"]?>" class="text-decoration-none">
                    <div class="cc-card">
                        <img 
                        <?php
                            if(is_null($row["s_pic"])){echo "src='/CafeConnect/assets/img/default.jpg'";}
                            else{echo "src=\"/CafeConnect/assets/img/{$row['s_pic']}\"";}
                        ?> 
                        class="cc-card-image" alt="<?php echo htmlspecialchars($row["s_name"])?>">
                        <div class="p-3">
                            <h4 name="shop-name" class="cc-text-espresso mb-2"><?php echo htmlspecialchars($row["s_name"])?></h4>
                            <?php 
                                $open = explode(":",$row["s_openhour"]);
                                $close = explode(":",$row["s_closehour"]);
                            ?>
                            <p class="text-muted small mb-2"><i class="bi bi-clock"></i> <?php echo $open[0].":".$open[1]." - ".$close[0].":".$close[1]?></p>
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
                                <?php }     ?>
                            </div>
                            <div class="text-center">
                                <span class="btn-cc-primary w-100 d-block">View Menu</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID EACH SHOP -->
        <?php } 
        }else{
            ?>
            </div>
            <div class="row row-cols-1">
                    <div class="col pt-3 px-3 bg-danger text-white rounded text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                            class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                        <p class="ms-2 mt-2">No shop currently available for order!</p>
                    </div>
            </div>
            <?php
        }
            $result -> free_result();
        ?>
        </div>
        <!-- END GRID SHOPS SELECTION -->

    </div>

    <?php include('../includes/footer_customer.php'); ?>
</body>

</html>
