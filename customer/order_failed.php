<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        session_start(); 
        include("../config/conn_db.php"); 
        include('../includes/head.php');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Failed | CafeConnect</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        }
        .error-container {
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: white;
            border-radius: 16px;
            padding: 60px 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .error-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }
        .error-icon i {
            color: white;
            font-size: 50px;
        }
        .error-card h2 {
            color: #1a1a1a;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 28px;
        }
        .error-card p {
            color: #666;
            margin-bottom: 15px;
            font-size: 15px;
            line-height: 1.6;
        }
        .error-message {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 10px;
            padding: 15px;
            margin: 25px 0;
            text-align: left;
        }
        .error-message-label {
            color: #991b1b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 700;
        }
        .error-message-text {
            color: #7f1d1d;
            font-size: 14px;
            word-break: break-word;
            font-family: 'Courier New', monospace;
            line-height: 1.5;
        }
        .retry-info {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            border-radius: 8px;
            margin-top: 25px;
            text-align: left;
        }
        .retry-info h5 {
            color: #1e40af;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .retry-info ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .retry-info li {
            color: #1e3a8a;
            font-size: 13px;
            margin-bottom: 6px;
            padding-left: 20px;
            position: relative;
        }
        .retry-info li:before {
            content: "◆";
            position: absolute;
            left: 0;
            color: #3b82f6;
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
        .btn-retry {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        .btn-retry:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php include('../includes/nav_header.php')?>
    
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            
            <h2>Order Could Not Be Placed</h2>
            
            <?php
                $error_message = "An unexpected error occurred. Please try again.";
                
                if(isset($_GET["pmt_err"])){
                    $error_message = htmlspecialchars($_GET["pmt_err"]);
                    $error_type = "Payment Error";
                } else if(isset($_GET["err"])){
                    $error_type = "System Error";
                    $error_message = "Error Code: " . htmlspecialchars($_GET["err"]);
                } else {
                    $error_type = "Processing Error";
                }
            ?>
            
            <p>We encountered a problem while processing your order. The payment could not be completed.</p>
            
            <div class="error-message">
                <div class="error-message-label">Error Details</div>
                <div class="error-message-text"><?php echo $error_message; ?></div>
            </div>
            
            <div class="retry-info">
                <h5>Why did this happen?</h5>
                <ul>
                    <li>Incorrect card details were provided</li>
                    <li>Card has insufficient funds</li>
                    <li>Card has expired or was declined</li>
                    <li>Network or system issue occurred</li>
                </ul>
            </div>
            
            <div class="button-group">
                <a href="home.php" class="btn-home">← Back to Home</a>
                <a href="cust_cart.php" class="btn-retry">← Try Again</a>
            </div>
        </div>
    </div>

    <div class="mt-5"></div>
    <?php include('../includes/footer_customer.php')?>
</body>

</html>
