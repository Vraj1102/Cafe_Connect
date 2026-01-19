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
    <title>Order Details | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-receipt"></i> Order Details</h2>

        <?php
        if (!isset($_GET['orh_id']) || !is_numeric($_GET['orh_id'])) {
            echo '<div class="alert alert-warning">Missing or invalid order id.</div>';
            include('../includes/footer_admin.php');
            exit();
        }
        $orh_id = (int) $_GET["orh_id"];
        $query = "SELECT orh.*, c.c_firstname, c.c_lastname, s.s_name, p.p_amount, p.p_method 
                 FROM order_header orh 
                 INNER JOIN customer c ON orh.c_id = c.c_id 
                 INNER JOIN shop s ON orh.s_id = s.s_id 
                 INNER JOIN payment p ON orh.p_id = p.p_id 
                 WHERE orh.orh_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $orh_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_array();
        if (!$order) {
            echo '<div class="alert alert-warning">Order not found.</div>';
            include('../includes/footer_admin.php');
            exit();
        }
        ?>

        <div class="card mt-4">
            <div class="card-header">
                <h5>Order #<?= $order['orh_refcode'] ?></h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Customer:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($order['c_firstname'] . ' ' . $order['c_lastname']) ?></dd>
                    
                    <dt class="col-sm-3">Shop:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($order['s_name']) ?></dd>
                    
                    <dt class="col-sm-3">Order Time:</dt>
                    <dd class="col-sm-9"><?= date('M j, Y H:i', strtotime($order['orh_ordertime'])) ?></dd>
                    
                    <dt class="col-sm-3">Pickup Time:</dt>
                    <dd class="col-sm-9"><?= date('M j, Y H:i', strtotime($order['orh_pickuptime'])) ?></dd>
                    
                    <dt class="col-sm-3">Status:</dt>
                    <dd class="col-sm-9">
                        <?php 
                        switch($order['orh_orderstatus']) {
                            case 'ACPT': echo '<span class="badge bg-warning">Accepted</span>'; break;
                            case 'FNSH': echo '<span class="badge bg-success">Finished</span>'; break;
                            default: echo '<span class="badge bg-secondary">' . $order['orh_orderstatus'] . '</span>';
                        }
                        ?>
                    </dd>
                    
                    <dt class="col-sm-3">Payment:</dt>
                    <dd class="col-sm-9"><?= $order['p_amount'] ?> Rs. (<?= htmlspecialchars($order['p_method']) ?>)</dd>
                </dl>

                <h6 class="mt-4">Order Items:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Food Item</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $items_query = "SELECT ord.*, f.f_name FROM order_detail ord 
                                          INNER JOIN food f ON ord.f_id = f.f_id 
                                          WHERE ord.orh_id = ?";
                            $items_stmt = $mysqli->prepare($items_query);
                            $items_stmt->bind_param("i", $orh_id);
                            $items_stmt->execute();
                            $items_result = $items_stmt->get_result();
                            
                            while($item = $items_result->fetch_array()){
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($item['f_name']) ?></td>
                                <td><?= $item['ord_amount'] ?></td>
                                <td><?= $item['ord_buyprice'] ?> Rs.</td>
                                <td><?= $item['ord_amount'] * $item['ord_buyprice'] ?> Rs.</td>
                                <td><?= htmlspecialchars($item['ord_note']) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <a href="admin_order_list.php" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>