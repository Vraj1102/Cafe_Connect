# CafeConnect Setup Instructions

## After Cloning the Repository

### 1. Configure Database Connection
```bash
cd config/
copy conn_db.example.php conn_db.php
```
Edit `conn_db.php` with your database credentials.

### 2. Configure Stripe Payment
```bash
cd config/
copy stripe_config.example.php stripe_config.php
```
Edit `stripe_config.php` with your Stripe API keys from https://dashboard.stripe.com/test/apikeys

### 3. Install Dependencies
```bash
composer install
```

### 4. Import Database
1. Open phpMyAdmin: http://localhost/phpmyadmin/
2. Create database: `cafeconnect`
3. Import: `database/cafeconnect.sql`

### 5. Run the Application
Open browser: http://localhost/CafeConnect/

## Default Credentials

**Admin:**
- Username: `admin`
- Password: `12345678`

**Customer:**
- Username: `keerthi`
- Password: `keerthi`

## Test Payment
- Card: `4242 4242 4242 4242`
- Expiry: Any future date
- CVC: Any 3 digits
