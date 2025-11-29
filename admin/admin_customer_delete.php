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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <title>Delete Customer | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 76px;">
    <?php include('nav_header_admin.php')?>

    <div class="container p-5">
        <a class="nav nav-item text-decoration-none text-muted mb-3" href="#" onclick="history.back();">
            <i class="bi bi-arrow-left-square me-2"></i>Go back
        </a>
        
        <h2 class="border-bottom pb-2"><i class="bi bi-trash"></i> Delete Customer</h2>

        <?php
        $cid = $_GET["c_id"];
        $query = "SELECT * FROM customer WHERE c_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        $customer = $result->fetch_array();
        ?>

        <div class="alert alert-danger mt-4">
            <h4 class="alert-heading">Warning!</h4>
            <p>You are about to delete the following customer account. This action cannot be undone.</p>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Customer Information</h5>
                <dl class="row">
                    <dt class="col-sm-3">Name:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($customer['c_firstname'] . ' ' . $customer['c_lastname']) ?></dd>
                    
                    <dt class="col-sm-3">Username:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($customer['c_username']) ?></dd>
                    
                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9"><?= htmlspecialchars($customer['c_email']) ?></dd>
                    
                    <dt class="col-sm-3">Type:</dt>
                    <dd class="col-sm-9">
                        <?php 
                        switch($customer['c_type']) {
                            case 'STD': echo 'Student'; break;
                            case 'INS': echo 'Instructor'; break;
                            case 'STF': echo 'Staff'; break;
                            case 'GUE': echo 'Guest'; break;
                            case 'ADM': echo 'Admin'; break;
                            default: echo 'Others';
                        }
                        ?>
                    </dd>
                </dl>
                
                <form method="POST" action="admin_customer_delete_confirm.php" class="mt-4">
                    <input type="hidden" name="c_id" value="<?= $cid ?>">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer? This action cannot be undone.')">
                        <i class="bi bi-trash"></i> Delete Customer
                    </button>
                    <a href="admin_customer_detail.php?c_id=<?= $cid ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <?php include('../includes/footer_admin.php'); ?>
</body>
</html>