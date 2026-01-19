# Stripe Payment Integration Guide

## Step 1: Install Stripe PHP Library

Open Command Prompt in `C:\xampp\htdocs\CafeConnect\` and run:

```bash
composer require stripe/stripe-php
```

If you don't have Composer installed:
1. Download from https://getcomposer.org/download/
2. Install Composer
3. Run the command above

## Step 2: Get Stripe API Keys

1. Sign up at https://stripe.com
2. Go to Dashboard → Developers → API keys
3. Copy your:
   - Publishable key (starts with `pk_test_`)
   - Secret key (starts with `sk_test_`)

## Step 3: Create Stripe Configuration File

Create `config/stripe_config.php` with your keys:

```php
<?php
// Stripe API Keys
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_YOUR_PUBLISHABLE_KEY');
define('STRIPE_SECRET_KEY', 'sk_test_YOUR_SECRET_KEY');
?>
```

## Step 4: Files Updated

The following files have been updated to use Stripe:
- `customer/cust_cart.php` - Updated checkout form with Stripe Elements
- `customer/add_order.php` - Updated payment processing
- `customer/stripe_checkout.php` - New Stripe checkout page

## Step 5: Test Payment

Use Stripe test cards:
- Success: 4242 4242 4242 4242
- Decline: 4000 0000 0000 0002
- Any future expiry date, any 3-digit CVC

## Currency

Changed from THB (Thai Baht) to INR (Indian Rupees) to match your Rs. pricing.
