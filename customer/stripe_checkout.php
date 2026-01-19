<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        session_start(); 
        include("../config/conn_db.php"); 
        include('../includes/head.php');
        include('../config/stripe_config.php');
        
        if(!isset($_SESSION["cid"])){
            header("location: ../includes/restricted.php");
            exit(1);
        }
        
        // Calculate total from cart
        $cid = $_SESSION['cid'];
        $total = 0;
        $cart_stmt = $mysqli->prepare("SELECT f.f_price, ct.ct_amount FROM cart ct INNER JOIN food f ON ct.f_id = f.f_id WHERE ct.c_id = ?");
        $cart_stmt->bind_param("i", $cid);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();
        
        while($row = $cart_result->fetch_assoc()){
            $total += ($row['f_price'] * $row['ct_amount']);
        }
        
        // Convert to cents for Stripe
        $amount_cents = round($total * 100);
        
        // Create a Payment Intent
        try {
            $intent_data = [
                'amount' => $amount_cents,
                'currency' => STRIPE_CURRENCY,
                'description' => 'CafeConnect Order Payment - Customer ID: ' . $cid,
                'metadata[customer_id]' => $cid,
                'metadata[order_type]' => 'food_order'
            ];
            
            $intent = StripeAPI::createPaymentIntent($intent_data);
            
            if (isset($intent['error'])) {
                die('Error creating payment intent: ' . $intent['error']['message']);
            }
            
            $client_secret = $intent['client_secret'];
        } catch(Exception $e) {
            die('Error creating payment intent: ' . $e->getMessage());
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/main.css" rel="stylesheet">
    <link href="../assets/css/cafeconnect-design-system.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        body { padding-top: 85px; }
        .payment-card { background: white; border-radius: 12px; padding: 24px; border: 1px solid rgba(111, 78, 55, 0.1); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); }
        .StripeElement { background-color: white; padding: 10px 12px; border-radius: 4px; border: 1px solid #ced4da; box-sizing: border-box; height: 40px; }
        .StripeElement--focus { border-color: #6F4E37; box-shadow: 0 0 0 0.2rem rgba(111, 78, 55, 0.25); }
    </style>
    <title>Payment | CafeConnect</title>
</head>

<body class="d-flex flex-column h-100">
    <?php include('../includes/nav_header.php')?>

    <div class="container p-5">
        <h2 class="cc-text-coffee mb-4"><i class="bi bi-credit-card"></i> Secure Payment Checkout</h2>
        
        <div class="row">
            <div class="col-md-8">
                <div class="payment-card">
                    <h5 class="mb-3">Order Summary</h5>
                    <?php
                    $total = 0;
                    $cart_query = "SELECT ct.*, f.f_name, f.f_price, s.s_name 
                                  FROM cart ct 
                                  INNER JOIN food f ON ct.f_id = f.f_id 
                                  INNER JOIN shop s ON ct.s_id = s.s_id 
                                  WHERE ct.c_id = ?";
                    $stmt = $mysqli->prepare($cart_query);
                    $stmt->bind_param("i", $_SESSION['cid']);
                    $stmt->execute();
                    $cart_result = $stmt->get_result();
                    
                    while($row = $cart_result->fetch_assoc()){
                        $subtotal = $row['f_price'] * $row['ct_amount'];
                        $total += $subtotal;
                    ?>
                    <div class="d-flex justify-content-between mb-2 pb-2" style="border-bottom: 1px solid #eee;">
                        <div>
                            <strong><?= htmlspecialchars($row['f_name']) ?></strong>
                            <div class="small text-muted">x<?= $row['ct_amount'] ?> @ Rs. <?= number_format($row['f_price'], 2) ?></div>
                        </div>
                        <span>Rs. <?= number_format($subtotal, 2) ?></span>
                    </div>
                    <?php } ?>
                    <div class="d-flex justify-content-between mt-3 pt-3" style="border-top: 2px solid #6F4E37;">
                        <strong style="font-size: 1.2rem;">Total Amount:</strong>
                        <strong style="font-size: 1.2rem; color: var(--cc-coffee-brown);">Rs. <?= number_format($total, 2) ?></strong>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="payment-card">
                    <h5 class="mb-4">Payment Method</h5>
                    <form id="payment-form" action="stripe_payment.php" method="POST">
                        <div class="mb-3">
                            <label for="pickuptime" class="form-label">Pickup Time *</label>
                            <input type="datetime-local" class="form-control" id="pickuptime" name="pickuptime" required>
                            <small class="text-muted d-block mt-1">Select when you'll pick up your order</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Card Details *</label>
                            <div id="card-element" class="StripeElement"></div>
                            <div id="card-errors" role="alert" class="text-danger mt-2 small"></div>
                        </div>
                        
                        <input type="hidden" name="payamount" value="<?= $total ?>">
                        <input type="hidden" name="payment_intent_id" id="payment_intent_id" value="<?= $intent['id'] ?>">
                        <input type="hidden" name="client_secret" value="<?= $client_secret ?>">
                        
                        <button type="submit" id="submit-button" class="btn-cc-primary w-100">
                            <i class="bi bi-lock-fill me-1"></i>Pay Securely - Rs. <?= number_format($total, 2) ?>
                        </button>
                        
                        <small class="text-muted d-block mt-2 text-center">
                            <i class="bi bi-shield-check"></i> Secured by Stripe • PCI Compliant
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Stripe
        const stripe = Stripe('<?= STRIPE_PUBLISHABLE_KEY ?>');
        const elements = stripe.elements();

        // Create card element with styling
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    fontFamily: 'inter, sans-serif',
                    color: '#2C1810',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
        });
        cardElement.mount('#card-element');

        // Handle form submission
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const cardErrors = document.getElementById('card-errors');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            submitButton.disabled = true;
            submitButton.textContent = '<i class="bi bi-hourglass-split me-1"></i>Processing...';

            const {error, paymentMethod} = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
            });

            if (error) {
                cardErrors.textContent = error.message;
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="bi bi-lock-fill me-1"></i>Pay Securely - Rs. <?= number_format($total, 2) ?>';
            } else {
                // Add payment method ID to form and submit
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'paymentMethodId');
                hiddenInput.setAttribute('value', paymentMethod.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });

        // Handle card element changes
        cardElement.on('change', ({error}) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.textContent = error.message;
            } else {
                displayError.textContent = '';
            }
        });
    </script>

    <?php include('../includes/footer_customer.php'); ?>
</body>
</html>