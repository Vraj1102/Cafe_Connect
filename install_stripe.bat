@echo off
echo ========================================
echo CafeConnect - Stripe Integration Setup
echo ========================================
echo.
echo Installing Stripe PHP Library...
echo.

cd /d "%~dp0"

composer require stripe/stripe-php

echo.
echo ========================================
echo Installation Complete!
echo ========================================
echo.
echo Next Steps:
echo 1. Get your Stripe API keys from https://dashboard.stripe.com/test/apikeys
echo 2. Edit config/stripe_config.php and add your keys
echo 3. Test payment with card: 4242 4242 4242 4242
echo.
pause
