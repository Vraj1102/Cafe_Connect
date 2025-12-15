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
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        body { padding-top: 85px; }
    </style>
    <title>Menu List | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <h2 class="cc-text-coffee mb-4"><i class="bi bi-cup-hot"></i> Menu Management</h2>
        
        <div class="table-responsive cc-card">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Food Name</th>
                        <th>Shop</th>
                        <th>Price</th>
                        <th>Available Today</th>
                        <th>Pre-order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT f.*, s.s_name FROM food f 
                             INNER JOIN shop s ON f.s_id = s.s_id 
                             ORDER BY s.s_name, f.f_name";
                    $result = $mysqli->query($query);
                    $i = 1;
                    while($row = $result->fetch_array()){
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['f_name']) ?></td>
                        <td><?= htmlspecialchars($row['s_name']) ?></td>
                        <td><?= $row['f_price'] ?> Rs.</td>
                        <td>
                            <?php if($row['f_todayavail'] == 1): ?>
                                <span class="cc-badge cc-badge-open">Yes</span>
                            <?php else: ?>
                                <span class="cc-badge cc-badge-closed">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['f_preorderavail'] == 1): ?>
                                <span class="cc-badge cc-badge-preorder">Yes</span>
                            <?php else: ?>
                                <span class="cc-badge cc-badge-closed">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <a href="admin_food_detail.php?f_id=<?= $row['f_id'] ?>" class="btn-cc-primary btn-sm">View</a>
                                <a href="admin_food_edit.php?f_id=<?= $row['f_id'] ?>" class="btn-cc-success btn-sm">Edit</a>
                            </div>
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