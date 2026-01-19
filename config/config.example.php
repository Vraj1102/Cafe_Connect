<?php
/**
 * CafeConnect Configuration Template
 * Copy this file to config.php and update with your settings
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cafeconnect');

// Application Settings
define('APP_NAME', 'CafeConnect');
define('APP_URL', 'http://localhost/CafeConnect/');
define('TIMEZONE', 'Asia/Kolkata');

// File Upload Settings
define('UPLOAD_PATH', 'assets/img/');
define('MAX_FILE_SIZE', 5242880); // 5MB in bytes

// Session Settings
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds

// Stripe Configuration (Update with your keys)
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_your_publishable_key_here');
define('STRIPE_SECRET_KEY', 'sk_test_your_secret_key_here');

// Email Configuration (Optional)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your_email@gmail.com');
define('SMTP_PASSWORD', 'your_app_password');

// Security Settings
define('HASH_ALGORITHM', 'sha256');
define('SALT', 'your_random_salt_here');

// Development Settings
define('DEBUG_MODE', true);
define('ERROR_REPORTING', E_ALL);

// Set timezone
date_default_timezone_set(TIMEZONE);

// Error reporting based on debug mode
if (DEBUG_MODE) {
    error_reporting(ERROR_REPORTING);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>