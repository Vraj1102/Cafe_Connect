# Developer Guide - Sai Cafe

## Quick Start

### File Path References
After restructuring, update your includes as follows:

**Old Path → New Path**
```php
// Database connection
include("conn_db.php")           → include("config/conn_db.php")
include("../conn_db.php")        → include("../config/conn_db.php")

// Common includes
include("head.php")              → include("includes/head.php")
include("nav_header.php")        → include("includes/nav_header.php")
include("db_error.php")          → include("includes/db_error.php")

// Assets
href="css/main.css"              → href="assets/css/main.css"
src="js/script.js"               → src="assets/js/script.js"
src="img/photo.jpg"              → src="assets/img/photo.jpg"

// Customer files
include("cust_*.php")            → include("customer/cust_*.php")
```

## Directory Purpose

### `/admin/`
Admin panel for managing the entire system
- Customer management
- Shop management
- Food menu management
- Order management
- Reports and analytics

### `/shop/`
Shop owner panel for managing their shop
- Menu management (add, edit, delete items)
- Order processing
- Shop profile management
- Revenue reports

### `/customer/`
Customer-facing functionality
- Registration and login
- Browse shops and menus
- Shopping cart
- Order placement and history
- Profile management

### `/assets/`
Static resources
- `css/` - Stylesheets
- `js/` - JavaScript files
- `img/` - Images (shop photos, food items)

### `/config/`
Configuration files
- `conn_db.php` - Database connection
- `config.example.php` - Template for configuration

### `/includes/`
Common include files used across the application
- `head.php` - HTML head section
- `nav_header.php` - Navigation header
- `check_login.php` - Authentication check
- `logout.php` - Logout handler
- `restricted.php` - Access control

### `/database/`
Database schema and migrations
- `saicafe.sql` - Complete database schema

### `/vendor/`
Third-party libraries
- `omise-php/` - Payment gateway integration

## Common Tasks

### Adding a New Page

1. **Customer Page**
   - Create file in `/customer/` directory
   - Include: `session_start()`, `config/conn_db.php`, `includes/head.php`
   - Use relative paths: `../config/`, `../includes/`, `../assets/`

2. **Admin Page**
   - Create file in `/admin/` directory
   - Include authentication check
   - Use relative paths from admin directory

3. **Shop Page**
   - Create file in `/shop/` directory
   - Include shop authentication
   - Use relative paths from shop directory

### Database Connection
```php
<?php
session_start();
include("../config/conn_db.php");
// Your code here
?>
```

### Including Assets
```html
<!-- CSS -->
<link href="../assets/css/main.css" rel="stylesheet">

<!-- JavaScript -->
<script src="../assets/js/script.js"></script>

<!-- Images -->
<img src="../assets/img/photo.jpg" alt="Photo">
```

## Database Schema

### Key Tables
- `customer` - User accounts
- `shop` - Shop information
- `food` - Menu items
- `cart` - Shopping cart items
- `order_header` - Order master records
- `order_detail` - Order line items
- `payment` - Payment transactions

### Stored Procedures
- `customer_order(order_id)` - Get order details
- `customer_order_history(customer_id)` - Get order history
- `shop_alltime_revenue(shop_id)` - Calculate total revenue
- `shop_menu_revenue(shop_id)` - Revenue by menu item

## Security Notes

1. Always use `session_start()` at the beginning of protected pages
2. Validate user authentication before displaying sensitive data
3. Use prepared statements for database queries
4. Sanitize user inputs
5. Never commit `config/conn_db.php` with real credentials

## Testing

### Local Testing
1. Ensure XAMPP is running (Apache + MySQL)
2. Access via `http://localhost/Sai Cafe/`
3. Test all user roles: Customer, Shop Owner, Admin

### Test Accounts
- Admin: `admin` / `12345678`
- Customer: `keerthi` / `keerthi`

## Troubleshooting

### Common Issues

**Database Connection Error**
- Check MySQL is running in XAMPP
- Verify database name is `saicafe`
- Check credentials in `config/conn_db.php`

**File Not Found Errors**
- Update include paths to new structure
- Check relative paths from current directory
- Ensure files are in correct directories

**Image Not Loading**
- Verify image path: `assets/img/filename.jpg`
- Check file exists in assets/img directory
- Ensure proper file permissions

## Best Practices

1. **File Organization**
   - Keep related files in appropriate directories
   - Use descriptive file names
   - Follow existing naming conventions

2. **Code Style**
   - Use consistent indentation
   - Comment complex logic
   - Follow PHP best practices

3. **Database**
   - Use prepared statements
   - Close connections when done
   - Handle errors gracefully

4. **Version Control**
   - Use .gitignore for sensitive files
   - Commit frequently with clear messages
   - Keep config files separate

## Support

For issues or questions, contact the development team:
- Vraj
- Raj
- Saikiran
