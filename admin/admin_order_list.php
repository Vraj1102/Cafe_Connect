<!DOCTYPE html>
<html lang="en" class="h-100">
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <title>Order List | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5" style="padding-top: 100px !important;">
        <h2 class="border-bottom pb-2"><i class="bi bi-receipt"></i> Order Management</h2>
        
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Shop</th>
                        <th>Order Time</th>
                        <th>Pickup Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT orh.*, c.c_firstname, c.c_lastname, s.s_name, p.p_amount 
                             FROM order_header orh 
                             INNER JOIN customer c ON orh.c_id = c.c_id 
                             INNER JOIN shop s ON orh.s_id = s.s_id 
                             INNER JOIN payment p ON orh.p_id = p.p_id 
                             ORDER BY orh.orh_ordertime DESC 
                             LIMIT 50";
                    $result = $mysqli->query($query);
                    $i = 1;
                    while($row = $result->fetch_array()){
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= $row['orh_refcode'] ?></td>
                        <td><?= htmlspecialchars($row['c_firstname'] . ' ' . $row['c_lastname']) ?></td>
                        <td><?= htmlspecialchars($row['s_name']) ?></td>
                        <td><?= date('M j, Y H:i', strtotime($row['orh_ordertime'])) ?></td>
                        <td><?= date('M j, Y H:i', strtotime($row['orh_pickuptime'])) ?></td>
                        <td>
                            <?php 
                            switch($row['orh_orderstatus']) {
                                case 'ACPT': echo '<span class="badge bg-warning">Accepted</span>'; break;
                                case 'FNSH': echo '<span class="badge bg-success">Finished</span>'; break;
                                default: echo '<span class="badge bg-secondary">' . $row['orh_orderstatus'] . '</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="admin_order_detail.php?orh_id=<?= $row['orh_id'] ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>