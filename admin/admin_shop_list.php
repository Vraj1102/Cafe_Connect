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
    <title>Shop List | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5" style="padding-top: 100px !important;">
        <h2 class="border-bottom pb-2"><i class="bi bi-shop"></i> Shop Management</h2>
        
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Shop Name</th>
                        <th>Location</th>
                        <th>Open Hours</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM shop ORDER BY s_name";
                    $result = $mysqli->query($query);
                    $i = 1;
                    while($row = $result->fetch_array()){
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['s_name']) ?></td>
                        <td><?= htmlspecialchars($row['s_location']) ?></td>
                        <td><?= $row['s_openhour'] ?> - <?= $row['s_closehour'] ?></td>
                        <td>
                            <?php if($row['s_status'] == 1): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="admin_shop_detail.php?s_id=<?= $row['s_id'] ?>" class="btn btn-sm btn-primary">View</a>
                            <a href="admin_shop_edit.php?s_id=<?= $row['s_id'] ?>" class="btn btn-sm btn-success">Edit</a>
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