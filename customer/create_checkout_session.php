<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/stripe_config.php';
require_once '../config/conn_db.php';

if(!isset($_SESSION['cid'])){
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

header('Content-Type: application/json');

try {
    $pickuptime = $_POST['pickuptime'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    
    // Get shop name
    $shop_query = "SELECT s_name FROM shop WHERE s_id = (SELECT s_id FROM cart WHERE c_id = {$_SESSION['cid']} LIMIT 1)";
    $shop_result = $mysqli->query($shop_query);
    $shop_name = $shop_result->fetch_array()['s_name'] ?? 'CafeConnect';
    
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => STRIPE_CURRENCY,
                'product_data' => [
                    'name' => 'CafeConnect Order',
                    'description' => 'Food order from ' . $shop_name,
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => 'http://localhost/CafeConnect/customer/stripe_success.php?session_id={CHECKOUT_SESSION_ID}&pickuptime=' . urlencode($pickuptime) . '&amount=' . $amount,
        'cancel_url' => 'http://localhost/CafeConnect/customer/cust_cart.php?payment=cancelled',
    ]);

    echo json_encode(['id' => $checkout_session->id]);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
