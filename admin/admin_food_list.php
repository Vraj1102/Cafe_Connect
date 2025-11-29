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
    <title>Menu List | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5" style="padding-top: 100px !important;">
        <h2 class="border-bottom pb-2"><i class="bi bi-card-list"></i> Menu Management</h2>
        
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
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
                                <span class="badge bg-success">Yes</span>
                            <?php else: ?>
                                <span class="badge bg-danger">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['f_preorderavail'] == 1): ?>
                                <span class="badge bg-info">Yes</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="admin_food_detail.php?f_id=<?= $row['f_id'] ?>" class="btn btn-sm btn-primary">View</a>
                            <a href="admin_food_edit.php?f_id=<?= $row['f_id'] ?>" class="btn btn-sm btn-success">Edit</a>
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