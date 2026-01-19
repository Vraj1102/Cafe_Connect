<?php
session_start();
require_once '../config/conn_db.php';

if (!isset($_SESSION['sid'])) {
    header("Location: ../login.php");
    exit();
}

$shop_id = $_SESSION['sid'];

// Fetch shop stats with prepared statements
$order_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM order_header WHERE s_id = ?");
$order_stmt->bind_param("i", $shop_id);
$order_stmt->execute();
$order_cnt = $order_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

// Count pending orders
$pending_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM order_header WHERE s_id = ? AND orh_orderstatus = 'PEND'");
$pending_stmt->bind_param("i", $shop_id);
$pending_stmt->execute();
$pending_cnt = $pending_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

// Count menu items
$menu_stmt = $mysqli->prepare("SELECT COUNT(*) AS cnt FROM food WHERE s_id = ?");
$menu_stmt->bind_param("i", $shop_id);
$menu_stmt->execute();
$menu_cnt = $menu_stmt->get_result()->fetch_assoc()['cnt'] ?? 0;

// Total revenue for this shop
$revenue_stmt = $mysqli->prepare("SELECT COALESCE(SUM(p.p_amount), 0) AS total FROM order_header orh INNER JOIN payment p ON orh.p_id = p.p_id WHERE orh.s_id = ? AND orh.orh_orderstatus = 'FNSH'");
$revenue_stmt->bind_param("i", $shop_id);
$revenue_stmt->execute();
$total_revenue = $revenue_stmt->get_result()->fetch_assoc()['total'] ?? 0;

// Recent orders for this shop (latest 6)
$recent_orders = [];
$orh_query = "SELECT orh.orh_id, orh.orh_refcode, orh.orh_orderstatus, orh.orh_ordertime, orh.orh_pickuptime, c.c_firstname, c.c_lastname, c.c_username
    FROM order_header orh 
    LEFT JOIN customer c ON orh.c_id = c.c_id 
    WHERE orh.s_id = ?
    ORDER BY orh.orh_id DESC LIMIT 6";
$orh_stmt = $mysqli->prepare($orh_query);
$orh_stmt->bind_param("i", $shop_id);
$orh_stmt->execute();
$orh_res = $orh_stmt->get_result();
if ($orh_res) {
    while ($r = $orh_res->fetch_assoc()) $recent_orders[] = $r;
}

// Top items by orders
$top_items = [];
$item_query = "SELECT f.f_id, f.f_name, f.f_price, COUNT(ord.f_id) as order_count
    FROM food f 
    LEFT JOIN order_detail ord ON f.f_id = ord.f_id
    WHERE f.s_id = ?
    GROUP BY f.f_id, f.f_name, f.f_price
    ORDER BY order_count DESC LIMIT 5";
$item_stmt = $mysqli->prepare($item_query);
$item_stmt->bind_param("i", $shop_id);
$item_stmt->execute();
$item_res = $item_stmt->get_result();
if ($item_res) {
    while ($r = $item_res->fetch_assoc()) $top_items[] = $r;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('../includes/head.php'); ?>
    <meta charset="utf-8">
    <title>Shop Dashboard - CafeConnect</title>
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <style>
        body{ 
            padding-top: 85px; 
            background: linear-gradient(135deg, #F4F1EA 0%, #FFF8E7 100%);
            min-height: 100vh;
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
    <?php include('nav_header_shop.php'); ?>

    <main class="flex-grow-1">
        <!-- Welcome Header -->
        <div class="container px-4 py-3">
            <div class="hero-welcome">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h2 class="mb-2">
                            <i class="bi bi-speedometer2 me-2"></i>Shop Dashboard
                        </h2>
                        <p class="mb-0">Welcome back, <strong><?= htmlspecialchars($_SESSION['shopname']) ?></strong>. Monitor orders and manage your menu.</p>
                    </div>
                    <div class="d-none d-md-flex gap-2">
                        <a href="shop_order_list.php" class="btn-cc-primary btn-sm">
                            <i class="bi bi-receipt-cutoff me-1"></i>View Orders
                        </a>
                        <a href="shop_menu_list.php" class="btn-cc-primary btn-sm">
                            <i class="bi bi-pencil-square me-1"></i>Manage Menu
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
                        <div class="stat-icon">📦</div>
                        <div class="stat-number"><?= number_format($order_cnt) ?></div>
                        <div class="stat-label">Total Orders</div>
                        <small class="text-muted d-block mt-2">All time</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">⏳</div>
                        <div class="stat-number"><?= number_format($pending_cnt) ?></div>
                        <div class="stat-label">Pending Orders</div>
                        <small class="text-muted d-block mt-2">Awaiting response</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">🍔</div>
                        <div class="stat-number"><?= number_format($menu_cnt) ?></div>
                        <div class="stat-label">Menu Items</div>
                        <small class="text-muted d-block mt-2">Available items</small>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon">💰</div>
                        <div class="stat-number">Rs. <?= number_format($total_revenue, 0) ?></div>
                        <div class="stat-label">Total Revenue</div>
                        <small class="text-muted d-block mt-2">Completed orders</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders & Top Items -->
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
                                    <a href="shop_order_detail.php?orh_id=<?= $or['orh_id'] ?>" class="list-group-item" style="text-decoration: none; color: inherit;">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="fw-bold mb-1"><?= htmlspecialchars($or['orh_refcode'] ?: "#" . $or['orh_id']) ?></div>
                                                <small class="text-muted">
                                                    👤 <?= htmlspecialchars($or['c_firstname'] . ' ' . $or['c_lastname']) ?> 
                                                    <span class="mx-1">•</span>
                                                    <?= htmlspecialchars($or['c_username'] ?? 'N/A') ?>
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
                            <a href="shop_order_list.php" class="btn btn-outline-primary btn-sm mt-3">View All Orders</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Top Menu Items -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="section-title mb-3" style="margin-bottom: 20px;">
                                <i class="bi bi-award"></i>Top Items
                            </h5>
                            <?php if (count($top_items) === 0): ?>
                                <p class="text-muted text-center py-4">No items yet.</p>
                            <?php else: ?>
                                <div>
                                <?php foreach ($top_items as $idx => $item): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid #EEE;">
                                        <div class="flex-grow-1">
                                            <span class="badge bg-warning text-dark me-2">#<?= $idx + 1 ?></span>
                                            <strong class="cc-text-coffee"><?= htmlspecialchars($item['f_name']) ?></strong>
                                            <div class="small text-muted">Rs. <?= number_format($item['f_price'], 2) ?></div>
                                        </div>
                                        <span class="badge bg-info"><?= $item['order_count'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <a href="shop_menu_list.php" class="btn btn-outline-primary btn-sm">Manage Menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="mt-5"></div>
    <?php include('../includes/footer_shop.php'); ?>
</body>
</html>