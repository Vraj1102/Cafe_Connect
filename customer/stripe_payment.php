<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
include('../config/conn_db.php');
include('../config/stripe_config.php');

// Validate session and input
if (!isset($_SESSION['cid']) || !isset($_POST['pickuptime']) || !isset($_POST['payamount']) || !isset($_POST['paymentMethodId']) || !isset($_POST['payment_intent_id'])) {
    header("Location: order_failed.php?pmt_err=Invalid request");
    exit();
}

$cid = $_SESSION['cid'];
$pickuptime = $_POST["pickuptime"];
$payamount = floatval($_POST["payamount"]);
$payment_method_id = $_POST["paymentMethodId"];
$payment_intent_id = $_POST["payment_intent_id"];

try {
    // Verify shop and pickup time
    $shop_stmt = $mysqli->prepare("SELECT s.s_id, s.s_openhour, s.s_closehour, s.s_status, s.s_preorderstatus 
        FROM shop s
        INNER JOIN cart ct ON s.s_id = ct.s_id 
        WHERE ct.c_id = ? 
        GROUP BY s.s_id LIMIT 1");
    $shop_stmt->bind_param("i", $cid);
    $shop_stmt->execute();
    $shop_result = $shop_stmt->get_result();
    
    if ($shop_result->num_rows === 0) {
        throw new Exception("Cart is empty or invalid");
    }
    
    $shop = $shop_result->fetch_assoc();
    $shop_id = $shop["s_id"];
    $shop_open = $shop["s_openhour"];
    $shop_close = $shop["s_closehour"];
    
    // Validate pickup time
    $pkt_arr = explode("T", $pickuptime);
    $pkt_date = $pkt_arr[0];
    $pkt_time = $pkt_arr[1];
    $now_date = date("Y-m-d");
    $tomorrow_date = (new DateTime($now_date))->add(new DateInterval("P1D"))->format('Y-m-d');
    
    $valid_time = false;
    if ($shop["s_status"] == 1 && $pkt_date == $now_date && $pkt_time >= $shop_open && $pkt_time <= $shop_close) {
        $valid_time = true;
    } elseif ($shop["s_preorderstatus"] == 1 && $pkt_date == $tomorrow_date && $pkt_time >= $shop_open && $pkt_time <= $shop_close) {
        $valid_time = true;
    }
    
    if (!$valid_time) {
        throw new Exception("Invalid pickup time. Shop is not open at the selected time.");
    }
    
    // Confirm the Payment Intent with Payment Method
    $intent = StripeAPI::retrievePaymentIntent($payment_intent_id);
    
    if (isset($intent['error'])) {
        throw new Exception("Payment intent retrieval failed: " . $intent['error']['message']);
    }
    
    $confirm_data = [
        'payment_method' => $payment_method_id,
        'return_url' => 'http://localhost/CafeConnect/customer/order_success.php'
    ];
    
    $confirmed_intent = StripeAPI::confirmPaymentIntent($payment_intent_id, $confirm_data);
    
    if (isset($confirmed_intent['error'])) {
        throw new Exception("Payment confirmation failed: " . $confirmed_intent['error']['message']);
    }
    
    // Check if payment succeeded
    if ($confirmed_intent['status'] !== 'succeeded' && $confirmed_intent['status'] !== 'requires_action') {
        throw new Exception("Payment intent confirmation failed: " . $confirmed_intent['status']);
    }
    
    // For SCA/3D Secure, status might be requires_action - handle in frontend
    if ($confirmed_intent['status'] === 'requires_action') {
        // Return to frontend to handle 3D Secure
        header('Content-Type: application/json');
        echo json_encode([
            'requires_action' => true,
            'client_secret' => $confirmed_intent['client_secret']
        ]);
        exit();
    }
    
    // Payment succeeded - create payment record
    $payment_reference = $confirmed_intent['id'];
    $payment_method = 'STRIPE';
    
    $pay_stmt = $mysqli->prepare("INSERT INTO payment (p_amount, p_method, p_status, p_reference, p_datetime) 
        VALUES (?, ?, 'PAID', ?, NOW())");
    $pay_stmt->bind_param("dss", $payamount, $payment_method, $payment_reference);
    
    if (!$pay_stmt->execute()) {
        throw new Exception("Failed to create payment record: " . $mysqli->error);
    }
    
    $pay_id = $mysqli->insert_id;
    
    // Create order header
    $orh_stmt = $mysqli->prepare("INSERT INTO order_header (c_id, s_id, p_id, orh_pickuptime, orh_orderstatus) 
        VALUES (?, ?, ?, ?, 'ACPT')");
    $orh_stmt->bind_param("iiis", $cid, $shop_id, $pay_id, $pickuptime);
    
    if (!$orh_stmt->execute()) {
        throw new Exception("Failed to create order header: " . $mysqli->error);
    }
    
    $orh_id = $mysqli->insert_id;
    
    // Generate Reference Code
    $orh_date = date("Ymd");
    $id_len = strlen((string)$orh_id);
    $lead0 = 7 - $id_len;
    $lead0str = str_repeat("0", $lead0);
    $orh_refcode = $orh_date . $lead0str . $orh_id;
    
    $update_stmt = $mysqli->prepare("UPDATE order_header SET orh_refcode = ? WHERE orh_id = ?");
    $update_stmt->bind_param("si", $orh_refcode, $orh_id);
    $update_stmt->execute();
    
    // Insert order details
    $cart_stmt = $mysqli->prepare("SELECT f.f_price, ct.ct_amount, ct.ct_note, ct.f_id 
        FROM cart ct 
        INNER JOIN food f ON ct.f_id = f.f_id 
        WHERE ct.c_id = ? AND ct.s_id = ?");
    $cart_stmt->bind_param("ii", $cid, $shop_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();
    
    $order_details_inserted = false;
    while ($cart_row = $cart_result->fetch_assoc()) {
        $ord_stmt = $mysqli->prepare("INSERT INTO order_detail (orh_id, f_id, ord_amount, ord_buyprice, ord_note) 
            VALUES (?, ?, ?, ?, ?)");
        $ord_stmt->bind_param("iiiis", $orh_id, $cart_row['f_id'], $cart_row['ct_amount'], $cart_row['f_price'], $cart_row['ct_note']);
        
        if (!$ord_stmt->execute()) {
            throw new Exception("Failed to create order detail: " . $mysqli->error);
        }
        $order_details_inserted = true;
    }
    
    if ($order_details_inserted) {
        // Delete cart items
        $del_stmt = $mysqli->prepare("DELETE FROM cart WHERE c_id = ? AND s_id = ?");
        $del_stmt->bind_param("ii", $cid, $shop_id);
        $del_stmt->execute();
        
        // Redirect to success page
        header("Location: order_success.php?orh=$orh_id");
        exit();
    } else {
        throw new Exception("No items found in cart");
    }
    
} catch (Exception $e) {
    // Handle all exceptions
    error_log("Payment processing error: " . $e->getMessage());
    header("Location: order_failed.php?pmt_err=" . urlencode($e->getMessage()));
    exit();
}
?>