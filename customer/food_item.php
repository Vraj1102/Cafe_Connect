<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start();
        include("../config/conn_db.php");
        include('../includes/head.php');
        if(!(isset($_GET["s_id"])||isset($_GET["f_id"]))){
            header("location: restricted.php");
            exit(1);
        }
        if(!isset($_SESSION["cid"])){
            header("location: cust_login.php");
            exit(1);
        }
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/menu.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        body { padding-top: 85px; }
    </style>
    <script type="text/javascript" src="../assets/js/input_number.js"></script>
    <script type="text/javascript">
        function changeshopcf(){
            return window.confirm("Do you want to change the shop?\nDon't worry we will do it for you automatically.");
        }
    </script>
    <title>Food Item | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php 
        include('../includes/nav_header.php');
        $f_id = isset($_GET["f_id"]) ? (int)$_GET["f_id"] : 0;
        $s_id = isset($_GET["s_id"]) ? (int)$_GET["s_id"] : 0;
        if($s_id === 0 && $f_id > 0){
            // derive shop id from food record if s_id not provided
            $slookup = $mysqli->query("SELECT s_id FROM food WHERE f_id = {$f_id} LIMIT 1");
            $srow = $slookup ? $slookup->fetch_array() : null;
            $s_id = $srow ? (int)$srow['s_id'] : 0;
            if($slookup){ $slookup->free_result(); }
        }

        if($f_id <= 0){
            echo '<div class="container pt-5"><div class="alert alert-warning">Invalid item specified.</div></div>';
            include('../includes/footer_customer.php');
            exit;
        }

        $query = "SELECT f.*,s.s_status,s.s_preorderstatus FROM food f INNER JOIN shop s ON f.s_id = s.s_id WHERE f.f_id = {$f_id} LIMIT 0,1";
        $result = $mysqli->query($query);
        if(!$result){
            echo '<div class="container pt-5"><div class="alert alert-danger">Failed to load item.</div></div>';
            include('../includes/footer_customer.php');
            exit;
        }
        $food_row = $result->fetch_array();
        if(!$food_row){
            echo '<div class="container pt-5"><div class="alert alert-info">Item not found.</div></div>';
            include('../includes/footer_customer.php');
            exit;
        }
    ?>
    <div class="container px-5 py-4" id="shop-body">
        <div class="row my-4">
            <a class="nav nav-item text-decoration-none text-muted mb-2" href="#" onclick="history.back();">
                <i class="bi bi-arrow-left-square me-2"></i>Go back
            </a>
        </div>
        <div class="row row-cols-1 row-cols-md-2 mb-5 g-4">
            <div class="col mb-3 mb-md-0">
                <div class="cc-card p-0">
                    <img 
                        <?php
                            if(is_null($food_row["f_pic"])){echo "src='/CafeConnect/assets/img/default.jpg'";}
                            else{echo "src='/CafeConnect/assets/img/{$food_row['f_pic']}'";}
                        ?> 
                        class="cc-card-image" 
                        alt="<?php echo htmlspecialchars($food_row["f_name"])?>">
                </div>
            </div>
            <div class="col text-wrap">
                <div class="cc-card">
                    <h1 class="cc-text-coffee mb-3"><?php echo htmlspecialchars($food_row["f_name"])?></h1>
                    <h3 class="cc-text-caramel mb-3"><?php echo $food_row["f_price"]?> Rs.</h3>
                    <div class="mb-4">
                        <?php if($food_row["f_todayavail"]==1&&$food_row["s_status"]==1){ ?>
                        <span class="cc-badge cc-badge-open">Available Now</span>
                        <?php }else{ ?>
                        <span class="cc-badge cc-badge-closed">Out of Order</span>
                        <?php }
                            if($food_row["f_preorderavail"]==1&&$food_row["s_preorderstatus"]==1){?>
                        <span class="cc-badge cc-badge-preorder">Pre-order available</span>
                        <?php }?>
                    </div>
                <div class="form-amount">
                    <form class="mt-3" method="POST" action="add_item.php">
                        <div class="input-group mb-3">
                            <button id="sub_btn" class="btn btn-outline-secondary" type="button" title="subtract amount" onclick="sub_amt('amount')">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                            <input type="number" class="form-control text-center border-secondary" id="amount"
                                name="amount" value="1" min="1" max="99">
                            <button id="add_btn" class="btn btn-outline-secondary" type="button" title="add amount" onclick="add_amt('amount')">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                        <input type="hidden" name="s_id" value="<?php echo $s_id?>">
                        <input type="hidden" name="f_id" value="<?php echo $f_id?>">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="addrequest" name="request" placeholder=" ">
                            <label for="addrequest" class="d-inline-text">Additional Request (Optional)</label>
                            <div id="addrequest_helptext" class="form-text">
                            </div>
                        </div>
                        <button class="btn-cc-success w-100" type="submit" title="add to cart" name="addtocart"
                        <?php
                            $cartsearch_query1 = "SELECT COUNT(*) AS cnt FROM cart WHERE c_id = {$_SESSION['cid']}";
                            $cartsearch_row1 = $mysqli -> query($cartsearch_query1) -> fetch_array();
                            if($cartsearch_row1["cnt"]>0){
                                $cartsearch_query2 = $cartsearch_query1." AND s_id = {$s_id}";
                                $cartsearch_row2 = $mysqli -> query($cartsearch_query2) -> fetch_array();
                                if($cartsearch_row2["cnt"]==0){?>
                                    onclick="javascript: return changeshopcf();"<?php 
                                } 
                            }
                        ?>
                        >
                            <i class="bi bi-cart-plus"></i> Add to cart
                        </button>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($result) && $result){ $result->free_result(); } ?>
    </div>
    <?php include('../includes/footer_customer.php'); ?>
</body>

</html>
