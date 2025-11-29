# CafeConnect - Online Food Ordering & Management System

A PHP-based multi-vendor cafe ordering platform for managing food orders, shops, and customers.

## Features

- Customer registration and authentication
- Browse shops and menus
- Shopping cart functionality
- Order management
- Admin panel for managing shops, food items, and orders
- Shop owner panel for managing menus and orders
- Pre-order functionality
- Payment integration (Omise)

## Project Structure

```
CafeConnect/
├── admin/              # Admin panel files
├── shop/               # Shop owner panel files
├── customer/           # Customer-related files
├── assets/             # Static assets
│   ├── css/           # Stylesheets
│   ├── js/            # JavaScript files
│   └── img/           # Images
├── config/             # Configuration files
│   └── conn_db.php    # Database connection
├── includes/           # Common include files
│   ├── head.php       # HTML head section
│   ├── nav_header.php # Navigation header
│   ├── db_error.php   # Database error page
│   ├── check_login.php # Login verification
│   ├── logout.php     # Logout handler
│   └── restricted.php # Access restriction
├── database/           # Database files
│   └── cafeconnect.sql    # Database schema
├── vendor/             # Third-party libraries
│   └── omise-php/     # Omise payment library
└── index.php           # Main entry point
```

## Installation Steps

### 1. Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Web browser

### 2. Download and Install XAMPP
- Download XAMPP from [official website](https://www.apachefriends.org/)
- Install XAMPP on your system

### 3. Setup Project
1. Copy the `CafeConnect` folder to `C:\xampp\htdocs\`
2. Start XAMPP Control Panel
3. Start Apache and MySQL services

### 4. Setup Database
1. Open browser and go to `http://localhost/phpmyadmin/`
2. Create a new database named `cafeconnect`
3. Import the database file:
   - Click on the `cafeconnect` database
   - Go to the `Import` tab
   - Choose file: `database/cafeconnect.sql`
   - Click `Go`

### 5. Configure Database Connection
Edit `config/conn_db.php` if needed:
```php
$mysqli = new mysqli("localhost", "root", "", "cafeconnect");
```

### 6. Run the Project
Open your browser and navigate to:
```
http://localhost/CafeConnect/
```

## Default Login Credentials

### Admin
- Username: `admin`
- Password: `12345678`

### Customer (Sample)
- Username: `keerthi`
- Password: `keerthi`

## Database Schema

### Main Tables
- `customer` - Customer information
- `shop` - Shop details
- `food` - Food menu items
- `cart` - Shopping cart
- `order_header` - Order information
- `order_detail` - Order items
- `payment` - Payment records

### Stored Procedures
- `customer_order` - Get order details
- `customer_order_history` - Get customer order history
- `shop_alltime_revenue` - Calculate shop revenue
- `shop_menu_revenue` - Calculate menu item revenue

## Technologies Used

- PHP 8.1+
- MySQL/MariaDB
- Bootstrap 5
- JavaScript
- Omise Payment Gateway

## Development Team

- Vraj
- Raj
- Saikiran

## Copyright

© 2024 CafeConnect Team
