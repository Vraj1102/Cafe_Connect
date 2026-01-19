<?php
session_start();
require_once '../config/conn_db.php';

if (!isset($_SESSION['aid']) || $_SESSION['utype'] != 'ADMIN') {
    header("Location: ../login.php");
    exit();
}

// Fetch summary counts with prepared statements
$cust_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM customer");
$cust_stmt->execute();
$cust_cnt = $cust_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

$shop_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM shop");
$shop_stmt->execute();
$shop_cnt = $shop_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

$food_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM food");
$food_stmt->execute();
$food_cnt = $food_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

$order_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM order_header");
$order_stmt->execute();
$order_cnt = $order_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

// Count pending orders
$pending_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM order_header WHERE orh_orderstatus = 'PEND'");
$pending_stmt->execute();
$pending_cnt = $pending_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

// Total revenue
$revenue_stmt = $mysqli->prepare("SELECT COALESCE(SUM(p.p_amount), 0) AS total FROM order_header orh INNER JOIN payment p ON orh.p_id = p.p_id WHERE orh.orh_orderstatus = 'FNSH'");
$revenue_stmt->execute();
$total_revenue = $revenue_stmt->get_result()->fetch_assoc()['total'] ?? 0;

// Recent orders (latest 8)
$recent_orders = [];
$orh_query = "SELECT orh.orh_id, orh.orh_refcode, orh.orh_orderstatus, orh.orh_pickuptime, orh.orh_ordertime, c.c_firstname, c.c_lastname, c.c_username, s.s_name
    FROM order_header orh 
    LEFT JOIN customer c ON orh.c_id = c.c_id 
    LEFT JOIN shop s ON orh.s_id = s.s_id
    ORDER BY orh.orh_id DESC LIMIT 8";
$orh_stmt = $mysqli->prepare($orh_query);
$orh_stmt->execute();
$orh_res = $orh_stmt->get_result();
if ($orh_res) {
    while ($r = $orh_res->fetch_assoc()) $recent_orders[] = $r;
}

// Top shops by orders
$top_shops = [];
$shop_query = "SELECT s.s_id, s.s_name, COUNT(orh.orh_id) as order_count
    FROM shop s 
    LEFT JOIN order_header orh ON s.s_id = orh.s_id
    GROUP BY s.s_id, s.s_name
    ORDER BY order_count DESC LIMIT 5";
$shop_stmt = $mysqli->prepare($shop_query);
$shop_stmt->execute();
$shop_res = $shop_stmt->get_result();
if ($shop_res) {
    while ($r = $shop_res->fetch_assoc()) $top_shops[] = $r;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../includes/head.php'); ?>
    <meta charset="utf-8">
    <title>Admin Dashboard - CafeConnect</title>
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        body{ 
            padding-top: 85px; 
            background: linear-gradient(135deg, #F4F1EA 0%, #FFF8E7 100%);
            min-height: 100vh;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--cc-deep-espresso) 0%, var(--cc-coffee-brown) 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 15px rgba(44, 24, 16, 0.15);
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            border: 1px solid rgba(111, 78, 55, 0.1);
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(111, 78, 55, 0.15);
            border-color: var(--cc-coffee-brown);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--cc-coffee-brown);
            line-height: 1;
            margin-bottom: 8px;
        }
        
        .stat-label {
            font-size: 0.95rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 12px;
            opacity: 0.7;
        }
        
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--cc-deep-espresso);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title::before {
            content: '';
            width: 4px;
            height: 24px;
            background: var(--cc-coffee-brown);
            border-radius: 2px;
        }
        
        .card {
            background: white;
            border: 1px solid rgba(111, 78, 55, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }
        
        .card-body {
            padding: 24px;
        }
        
        .list-group-item {
            border: 1px solid rgba(111, 78, 55, 0.1);
            border-radius: 8px;
            margin-bottom: 8px;
            padding: 16px;
            background: #FAFAFA;
            transition: all 0.2s ease;
        }
        
        .list-group-item:hover {
            background: white;
            border-color: var(--cc-coffee-brown);
            box-shadow: 0 2px 8px rgba(111, 78, 55, 0.1);
        }
        
        .order-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-pend {
            background: #FFF3CD;
            color: #856404;
        }
        
        .status-acpt {
            background: #D1ECF1;
            color: #0C5460;
        }
        
        .status-prep {
            background: #E2E3E5;
            color: #383D41;
        }
        
        .status-fnsh {
            background: #D4EDDA;
            color: #155724;
        }
        
        .status-canc {
            background: #F8D7DA;
            color: #721C24;
        }
        
        .shortcut-btn {
            background: white;
            border: 2px solid var(--cc-coffee-brown);
            color: var(--cc-coffee-brown);
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .shortcut-btn:hover {
            background: var(--cc-coffee-brown);
            color: white;
            transform: translateY(-2px);
        }
        
        .tip-item {
            padding: 12px 0;
            border-bottom: 1px solid #EEE;
            font-size: 0.95rem;
        }
        
        .tip-item:last-child {
            border-bottom: none;
        }
        
        .revenue-badge {
            background: var(--cc-fresh-green);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            display: inline-block;
        }
        
        .hero-welcome {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 5px solid var(--cc-coffee-brown);
        }
        
        .hero-welcome h2 {
            color: var(--cc-deep-espresso);
            margin-bottom: 8px;
        }
        
        .hero-welcome p {
            color: #6c757d;
            margin-bottom: 0;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php include('nav_header_admin.php'); ?>

    <main class="flex-grow-1">
        <!-- Welcome Header -->
        <div class="container px-4 py-3">
            <div class="hero-welcome">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="mb-2">
                            <i class="bi bi-speedometer2 me-2"></i>Admin Dashboard
                        </h2>
                        <p class="mb-0">Welcome back, <strong><?= htmlspecialchars($_SESSION['firstname'] ?? 'Admin') ?></strong>. Monitor platform performance and manage resources.</p>
                    </div>
                    <div class="d-none d-md-flex gap-2">
                        <a href="admin_order_list.php" class="btn-cc-primary btn-sm">
                            <i class="bi bi-receipt-cutoff me-1"></i>View Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="container px-4 mb-3">
            <h4 class="section-title">
                <i class="bi bi-graph-up"></i>Key Metrics
            </h4>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-number"><?= number_format($cust_cnt) ?></div>
                        <div class="stat-label">Customers</div>
                        <small class="text-muted d-block mt-2">Registered users</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">🏪</div>
                        <div class="stat-number"><?= number_format($shop_cnt) ?></div>
                        <div class="stat-label">Shops</div>
                        <small class="text-muted d-block mt-2">Active shops</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">🍔</div>
                        <div class="stat-number"><?= number_format($food_cnt) ?></div>
                        <div class="stat-label">Menu Items</div>
                        <small class="text-muted d-block mt-2">Total items</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">📦</div>
                        <div class="stat-number"><?= number_format($order_cnt) ?></div>
                        <div class="stat-label">Total Orders</div>
                        <small class="text-muted d-block mt-2">All time</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Stats Row -->
        <div class="container px-4 mb-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Pending Orders</h6>
                                    <div class="stat-number text-warning" style="color: var(--cc-warning);"><?= number_format($pending_cnt) ?></div>
                                </div>
                                <div style="font-size: 2.5rem;">⏳</div>
                            </div>
                            <a href="admin_order_list.php" class="btn btn-sm btn-outline-warning mt-2">View Orders</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted mb-1">Total Revenue</h6>
                                    <div class="stat-number" style="color: var(--cc-fresh-green);">Rs. <?= number_format($total_revenue, 2) ?></div>
                                </div>
                                <div style="font-size: 2.5rem;">💰</div>
                            </div>
                            <small class="text-muted">Completed orders only</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Top Shops -->
        <div class="container px-4 mb-3">
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="section-title mb-3" style="margin-bottom: 20px;">
                                <i class="bi bi-clock-history"></i>Recent Orders
                            </h5>
                            <?php if (count($recent_orders) === 0): ?>
                                <p class="text-muted text-center py-4">No orders yet.</p>
                            <?php else: ?>
                                <div>
                                <?php foreach ($recent_orders as $or): 
                                    $status = $or['orh_orderstatus'] ?? 'PEND';
                                    $status_class = 'status-' . strtolower($status);
                                ?>
                                    <a href="admin_order_detail.php?orh_id=<?= $or['orh_id'] ?>" class="list-group-item" style="text-decoration: none; color: inherit;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="fw-bold mb-1"><?= htmlspecialchars($or['orh_refcode'] ?: "#" . $or['orh_id']) ?></div>
                                                <small class="text-muted">
                                                    👤 <?= htmlspecialchars($or['c_firstname'] . ' ' . $or['c_lastname']) ?> 
                                                    <span class="mx-1">•</span>
                                                    🏪 <?= htmlspecialchars($or['s_name'] ?? 'N/A') ?>
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="order-status <?= $status_class ?>">
                                                    <?= htmlspecialchars($status) ?>
                                                </span>
                                                <div class="small text-muted mt-1"><?= date('M j, Y', strtotime($or['orh_ordertime'])) ?></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <a href="admin_order_list.php" class="btn btn-outline-primary btn-sm mt-3">View All Orders</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Top Shops -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="section-title mb-3" style="margin-bottom: 20px;">
                                <i class="bi bi-award"></i>Top Shops
                            </h5>
                            <?php if (count($top_shops) === 0): ?>
                                <p class="text-muted text-center py-4">No shops yet.</p>
                            <?php else: ?>
                                <div>
                                <?php foreach ($top_shops as $idx => $shop): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid #EEE;">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-warning text-dark">#<?= $idx + 1 ?></span>
                                            <a href="admin_shop_detail.php?s_id=<?= $shop['s_id'] ?>" style="text-decoration: none; color: var(--cc-coffee-brown); font-weight: 500;">
                                                <?= htmlspecialchars($shop['s_name']) ?>
                                            </a>
                                        </div>
                                        <span class="badge bg-info"><?= $shop['order_count'] ?> orders</span>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <a href="admin_shop_list.php" class="btn btn-outline-primary btn-sm">Manage Shops</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include('../includes/footer_admin.php'); ?>

</body>
</html>