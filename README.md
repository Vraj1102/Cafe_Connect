# CafeConnect - Online Food Ordering System

A modern PHP-based multi-vendor cafe ordering platform with Stripe payment integration, designed for seamless food ordering and management.

## 🚀 Features

### For Customers
- **User Registration & Authentication** - Secure account creation and login
- **Browse Multiple Cafes** - Explore various food vendors
- **Interactive Menu** - View detailed food items with images and prices
- **Shopping Cart** - Add, modify, and manage orders
- **Secure Payments** - Stripe integration for safe transactions
- **Order Tracking** - Real-time order status updates
- **Order History** - View past orders and reorder favorites
- **Pre-ordering** - Schedule orders for future pickup

### For Shop Owners
- **Shop Management** - Complete control over shop profile and settings
- **Menu Management** - Add, edit, and manage food items
- **Order Processing** - Accept, prepare, and complete orders
- **Real-time Updates** - Update order status (Preparing → Ready → Finished)
- **Sales Analytics** - Revenue tracking and reporting
- **Inventory Control** - Manage item availability

### For Administrators
- **System Overview** - Complete platform management
- **User Management** - Manage customers and shop owners
- **Shop Oversight** - Monitor all registered shops
- **Order Management** - System-wide order tracking
- **Analytics Dashboard** - Platform-wide statistics

## 🛠 Technology Stack

- **Backend**: PHP 8.1+
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, JavaScript, HTML5, CSS3
- **Payment Gateway**: Stripe Payment Intents API
- **Server**: Apache (XAMPP compatible)
- **Architecture**: MVC-inspired structure

## 📁 Project Structure

```
CafeConnect/
├── 📂 admin/                    # Admin Panel
│   ├── admin_*.php              # Admin management pages
│   └── check_admin_login.php    # Admin authentication
│
├── 📂 shop/                     # Shop Owner Panel  
│   ├── shop_*.php               # Shop management pages
│   └── check_shop_login.php     # Shop authentication
│
├── 📂 customer/                 # Customer Interface
│   ├── cust_*.php               # Customer account pages
│   ├── shop_*.php               # Shop browsing pages
│   ├── stripe_*.php             # Payment processing
│   └── order_*.php              # Order management
│
├── 📂 assets/                   # Static Resources
│   ├── css/                     # Stylesheets
│   ├── js/                      # JavaScript files
│   └── img/                     # Images and media
│
├── 📂 config/                   # Configuration
│   ├── conn_db.php              # Database connection
│   └── stripe_config.php        # Payment configuration
│
├── 📂 includes/                 # Shared Components
│   ├── nav_header.php           # Navigation
│   ├── footer_*.php             # Footer components
│   ├── head.php                 # HTML head section
│   └── *.php                    # Utility functions
│
├── 📂 database/                 # Database Schema
│   └── cafeconnectdb.sql        # Complete database setup
│
├── 📂 vendor/                   # Dependencies
│   └── stripe_simple.php        # Stripe API client
│
├── 📄 index.php                 # Landing page
├── 📄 login.php                 # Unified login system
├── 📄 about.php                 # About us page
└── 📄 README.md                 # This file
```

## ⚡ Quick Setup

### Prerequisites
- XAMPP (Apache + MySQL + PHP 8.1+)
- Web browser
- Stripe account (for payments)

### Installation Steps

1. **Download & Extract**
   ```bash
   git clone https://github.com/yourusername/CafeConnect.git
   # OR download ZIP and extract to C:\xampp\htdocs\
   ```

2. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL**

3. **Setup Database**
   - Go to `http://localhost/phpmyadmin/`
   - Create new database: `cafeconnectdb`
   - Import: `database/cafeconnectdb.sql`

4. **Configure Stripe (Optional)**
   - Get your Stripe keys from [Stripe Dashboard](https://dashboard.stripe.com/)
   - Update `config/stripe_config.php` with your keys

5. **Access Application**
   ```
   http://localhost/CafeConnect/
   ```

## 🔐 Default Login Credentials

### Administrator
- **Username**: `admin`
- **Password**: `12345678`
- **Access**: Complete system management

### Shop Owner (Sample)
- **Username**: `tastybites`
- **Password**: `shop123`
- **Access**: Shop management panel

### Customer (Sample)
- **Username**: `customer1`
- **Password**: `password123`
- **Access**: Customer ordering interface

## 💳 Payment Testing

Use Stripe test cards for payment testing:
- **Card Number**: `4242 4242 4242 4242`
- **Expiry**: Any future date
- **CVC**: Any 3 digits
- **ZIP**: Any 5 digits

## 📊 Database Schema

### Core Tables
- **`customer`** - Customer accounts and profiles
- **`admin`** - Administrator accounts
- **`shop`** - Shop information and settings
- **`food`** - Menu items with pricing and availability
- **`cart`** - Shopping cart management
- **`order_header`** - Order master records
- **`order_detail`** - Order line items
- **`payment`** - Payment transaction records

### Key Features
- **Foreign Key Constraints** - Data integrity
- **Stored Procedures** - Optimized queries
- **Indexes** - Performance optimization
- **Auto-increment IDs** - Unique identifiers

## 🎯 User Workflows

### Customer Journey
1. **Register/Login** → Browse Shops → View Menu → Add to Cart
2. **Checkout** → Stripe Payment → Order Confirmation
3. **Track Order** → Pickup Notification → Order Complete

### Shop Owner Journey
1. **Login** → Manage Menu → View Orders
2. **Process Orders** → Update Status → Complete Orders
3. **View Analytics** → Manage Shop Profile

### Admin Journey
1. **Login** → System Overview → Manage Users
2. **Monitor Orders** → Shop Management → System Reports

## 🔧 Customization

### Adding New Shops
1. Admin creates shop account
2. Shop owner logs in and sets up profile
3. Add menu items with images and pricing
4. Shop goes live for customer orders

### Adding New Features
- Follow existing file structure
- Use consistent naming conventions
- Include proper authentication checks
- Update database schema if needed

## 🚨 Security Features

- **Session Management** - Secure user sessions
- **SQL Injection Protection** - Prepared statements
- **Input Validation** - Server-side validation
- **Access Control** - Role-based permissions
- **Secure Payments** - PCI-compliant Stripe integration
- **Password Protection** - Secure authentication

## 📱 Responsive Design

- **Mobile-First** - Optimized for all devices
- **Bootstrap 5** - Modern responsive framework
- **Touch-Friendly** - Mobile-optimized interactions
- **Fast Loading** - Optimized assets and code

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Development Team

- **Vraj Patel** - Full Stack Developer

## 🆘 Support

For technical support or questions:
- Create an issue on GitHub
- Contact the development team
- Check the documentation

## 🎉 Acknowledgments

- Bootstrap team for the responsive framework
- Stripe for secure payment processing
- PHP community for excellent documentation
- All contributors and testers

---

**CafeConnect - Connecting Communities Through Food! ☕🍕**

*Made with ❤️ by Vraj Patel*