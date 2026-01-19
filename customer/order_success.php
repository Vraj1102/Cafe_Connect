<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        session_start(); 
        include("../config/conn_db.php");
        if(!isset($_SESSION["cid"]) || !isset($_GET["orh"])){
            header("location: ../includes/restricted.php");
            exit(1);
        }
        include('../includes/head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Placed Successfully | CafeConnect</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        }
        .success-container {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-card {
            background: white;
            border-radius: 16px;
            padding: 60px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }
        .success-icon i {
            color: white;
            font-size: 50px;
        }
        .success-card h2 {
            color: #1a1a1a;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .success-card p {
            color: #666;
            margin-bottom: 15px;
            font-size: 15px;
            line-height: 1.6;
        }
        .order-ref {
            background: #f0fdf4;
            border: 2px solid #d1fae5;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
        }
        .order-ref-label {
            color: #6b7280;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .order-ref-code {
            color: #10b981;
            font-size: 24px;
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }
        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }
        .button-group a {
            flex: 1;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-home {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #e5e7eb;
        }
        .btn-home:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }
        .btn-history {
            background: linear-gradient(135deg, #6F4E37 0%, #8B6F47 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(111, 78, 55, 0.3);
        }
        .btn-history:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(111, 78, 55, 0.4);
        }
        .next-steps {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            border-radius: 8px;
            margin-top: 25px;
            text-align: left;
        }
        .next-steps h5 {
            color: #92400e;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .next-steps ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .next-steps li {
            color: #78350f;
            font-size: 13px;
            margin-bottom: 6px;
            padding-left: 20px;
            position: relative;
        }
        .next-steps li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #f59e0b;
            font-weight: bold;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php include('../includes/nav_header.php')?>
    
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            
            <h2>Order Placed Successfully!</h2>
            <p>Your order has been submitted and confirmed. The shop will start preparing your order shortly.</p>
            
            <div class="order-ref">
                <div class="order-ref-label">Order Reference Number</div>
                <?php 
                    $orh_id = intval($_GET["orh"]);
                    $orh_stmt = $mysqli->prepare("SELECT orh_refcode FROM order_header WHERE orh_id = ? LIMIT 1");
                    $orh_stmt->bind_param("i", $orh_id);
                    $orh_stmt->execute();
                    $orh_result = $orh_stmt->get_result();
                    
                    if ($orh_result->num_rows > 0) {
                        $orh_arr = $orh_result->fetch_assoc();
                        $orh_refcode = $orh_arr["orh_refcode"];
                    } else {
                        $orh_refcode = "N/A";
                    }
                ?>
                <div class="order-ref-code">#<?php echo htmlspecialchars($orh_refcode); ?></div>
            </div>
            
            <p style="font-size: 13px; color: #999;">Please save your order reference number for your records.</p>
            
            <div class="next-steps">
                <h5>What happens next?</h5>
                <ul>
                    <li>Shop will receive and confirm your order</li>
                    <li>You'll receive status updates in order history</li>
                    <li>Arrive at pickup time to collect your order</li>
                </ul>
            </div>
            
            <div class="button-group">
                <a href="home.php" class="btn-home">← Back to Home</a>
                <a href="cust_order_history.php" class="btn-history">View Orders →</a>
            </div>
        </div>
    </div>

    <div class="mt-5"></div>
    <?php include('../includes/footer_customer.php')?>
</body>

</html>
