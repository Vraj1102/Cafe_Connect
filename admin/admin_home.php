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
    <link href="../assets/img/Main Logo 2.jpeg" rel="icon">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Admin Dashboard | CafeConnect</title>
</head>

<body class="d-flex flex-column" style="padding-top: 85px;">

    <?php include('nav_header_admin.php')?>

    <div class="d-flex text-center text-white py-3" style="background: linear-gradient(135deg, var(--cc-coffee-brown) 0%, var(--cc-caramel) 50%, var(--cc-caramel-light) 100%);">
        <div class="p-lg-2 mx-auto my-3">
            <h1 class="display-5 fw-normal">ADMIN DASHBOARD</h1>
            <p class="lead fw-normal" style="color: var(--cc-deep-espresso);">CafeConnect Management System</p>
        </div>
    </div>

    <div class="container p-5" id="admin-dashboard">
        <h2 class="cc-text-coffee mb-4"><i class="bi bi-graph-up"></i> System Status</h2>
        
        <!-- Charts Section -->
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="cc-card">
                    <div class="card-header cc-bg-latte">
                        <h5 class="cc-text-espresso mb-0"><i class="bi bi-pie-chart"></i> System Overview</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="systemChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="cc-card">
                    <div class="card-header cc-bg-latte">
                        <h5 class="cc-text-espresso mb-0"><i class="bi bi-bar-chart"></i> Monthly Orders</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADMIN GRID DASHBOARD -->
        <div class="row row-cols-1 row-cols-lg-2 align-items-stretch g-4 py-3">

            <!-- GRID OF CUSTOMER -->
            <div class="col">
                <a href="admin_customer_list.php" class="text-decoration-none">
                    <div class="cc-card" style="border-left: 4px solid var(--cc-caramel);">
                        <div class="card-body">
                            <h4 class="cc-text-espresso mb-3">
                                <i class="bi bi-person-fill" style="color: var(--cc-caramel);"></i>
                                Customer</h4>
                            <p class="text-muted my-2">
                                <span class="h5 cc-text-coffee">
                                    <?php
                                    $cust_query = "SELECT COUNT(*) AS cnt FROM customer;";
                                    $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                    echo $cust_arr["cnt"];
                                ?>
                                </span>
                                customer(s) in the system
                            </p>
                            <div class="text-end">
                                <span class="btn-cc-secondary btn-sm">Go to Customer List</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF CUSTOMER -->

            <!-- GRID OF SHOP -->
            <div class="col">
                <a href="admin_shop_list.php" class="text-decoration-none">
                    <div class="cc-card" style="border-left: 4px solid var(--cc-fresh-green);">
                        <div class="card-body">
                            <h4 class="cc-text-espresso mb-3">
                                <i class="bi bi-shop" style="color: var(--cc-fresh-green);"></i>
                                Food Shop</h4>
                            <p class="text-muted my-2">
                                <span class="h5 cc-text-coffee">
                                    <?php
                                    $cust_query = "SELECT COUNT(*) AS cnt FROM shop;";
                                    $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                    echo $cust_arr["cnt"];
                                ?>
                                </span>
                                food shop(s) in the system
                            </p>
                            <div class="text-end">
                                <span class="btn-cc-secondary btn-sm">Go to Food Shop List</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF SHOP -->

            <!-- GRID OF FOOD -->
            <div class="col">
                <a href="admin_food_list.php" class="text-decoration-none">
                    <div class="cc-card" style="border-left: 4px solid var(--cc-coffee-brown);">
                        <div class="card-body">
                            <h4 class="cc-text-espresso mb-3">
                                <i class="bi bi-card-list" style="color: var(--cc-coffee-brown);"></i>
                                Menu</h4>
                            <p class="text-muted my-2">
                                <span class="h5 cc-text-coffee">
                                    <?php
                                    $cust_query = "SELECT COUNT(*) AS cnt FROM food;";
                                    $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                    echo $cust_arr["cnt"];
                                ?>
                                </span>
                                menu(s) in the system
                            </p>
                            <div class="text-end">
                                <span class="btn-cc-secondary btn-sm">Go to Menu List</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF FOOD -->

            <!-- GRID OF ORDER -->
            <div class="col">
                <a href="admin_order_list.php" class="text-decoration-none">
                    <div class="cc-card" style="border-left: 4px solid var(--cc-gold);">
                        <div class="card-body">
                            <h4 class="cc-text-espresso mb-3">
                                <i class="bi bi-receipt" style="color: var(--cc-gold);"></i>
                                Order</h4>
                            <p class="text-muted my-2">
                                <span class="h5 cc-text-coffee">
                                    <?php
                                    $cust_query = "SELECT COUNT(*) AS cnt FROM order_header;";
                                    $cust_arr = $mysqli -> query($cust_query) -> fetch_array();
                                    echo $cust_arr["cnt"];
                                ?>
                                </span>
                                order(s) in the system
                            </p>
                            <div class="text-end">
                                <span class="btn-cc-secondary btn-sm">Go to Order List</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END GRID OF ORDER -->


        </div>
        <!-- END ADMIN GRID DASHBOARD -->

    </div>
    <?php include('../includes/footer_admin.php'); ?>

    <script>
        // System Overview Chart
        const systemCtx = document.getElementById('systemChart').getContext('2d');
        const systemChart = new Chart(systemCtx, {
            type: 'doughnut',
            data: {
                labels: ['Customers', 'Shops', 'Menu Items', 'Orders'],
                datasets: [{
                    data: [
                        <?php
                        $cust_query = "SELECT COUNT(*) AS cnt FROM customer";
                        echo $mysqli->query($cust_query)->fetch_array()["cnt"] . ",";
                        $shop_query = "SELECT COUNT(*) AS cnt FROM shop";
                        echo $mysqli->query($shop_query)->fetch_array()["cnt"] . ",";
                        $food_query = "SELECT COUNT(*) AS cnt FROM food";
                        echo $mysqli->query($food_query)->fetch_array()["cnt"] . ",";
                        $order_query = "SELECT COUNT(*) AS cnt FROM order_header";
                        echo $mysqli->query($order_query)->fetch_array()["cnt"];
                        ?>
                    ],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Monthly Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Orders',
                    data: [
                        <?php
                        // Get last 6 months order data
                        for($i = 5; $i >= 0; $i--) {
                            $month = date('Y-m', strtotime("-$i months"));
                            $monthly_query = "SELECT COUNT(*) as cnt FROM order_header WHERE DATE_FORMAT(orh_ordertime, '%Y-%m') = '$month'";
                            $result = $mysqli->query($monthly_query);
                            echo $result->fetch_array()["cnt"];
                            if($i > 0) echo ",";
                        }
                        ?>
                    ],
                    backgroundColor: '#36A2EB'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>