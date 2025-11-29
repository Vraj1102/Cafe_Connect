# CafeConnect Rebranding Guide

## Database Changes

### Step 1: Update Database Name
The database name has been changed from `saicafe` to `cafeconnect`

**Files Updated:**
- `database/saicafe.sql` → Database name changed to `cafeconnect`
- `config/conn_db.php` → Connection string updated

### Step 2: Import Database (No Errors)
1. Open phpMyAdmin: `http://localhost/phpmyadmin/`
2. Create new database: `cafeconnect`
3. Select the `cafeconnect` database
4. Go to Import tab
5. Choose file: `database/saicafe.sql` (it now creates `cafeconnect` database)
6. Click Go

**Note:** The SQL file will work without errors. If you already have `saicafe` database, you can:
- Option A: Drop the old `saicafe` database and import fresh
- Option B: Export data from `saicafe`, create `cafeconnect`, then import

## Folder Renaming

### Step 3: Rename Project Folder
1. Close XAMPP Apache service
2. Rename folder: `C:\xampp\htdocs\Sai Cafe` → `C:\xampp\htdocs\CafeConnect`
3. Restart Apache service

## Files That Need Manual Update

You need to search and replace "Sai Cafe" with "CafeConnect" in ALL PHP files:

### Critical Files to Update:
```
/admin/*.php
/shop/*.php
/customer/*.php
/includes/*.php
/auth_login.php
All other PHP files with paths
```

### Search & Replace Pattern:
- Find: `/Sai Cafe/`
- Replace: `/CafeConnect/`

- Find: `Sai Cafe`
- Replace: `CafeConnect`

## Logo & Images Suggestions

### Logo Ideas:
1. **Coffee cup with connection/network lines** - Represents cafe + connectivity
2. **Fork & spoon forming a wifi symbol** - Food + digital connection
3. **Coffee bean with circuit board pattern** - Traditional cafe meets technology

### Free Logo Resources:
- Canva.com (Free templates)
- LogoMakr.com
- Hatchful by Shopify

### Recommended Logo Specs:
- Main Logo: 500x500px (PNG with transparent background)
- Favicon: 32x32px
- Banner: 1920x600px

### Image Locations to Update:
```
/assets/img/logo.png (Create new logo)
/assets/img/favicon.ico (Create favicon)
/assets/img/Coffee Shop banner.jpg (Can keep or replace)
```

### Free Stock Images for Cafe:
- Unsplash.com (Search: "cafe", "coffee shop", "food ordering")
- Pexels.com
- Pixabay.com

## Resume Entry

### Professional Project Title:
**CafeConnect - Online Food Ordering & Management System**

### Resume Format:
```
CafeConnect - Multi-Vendor Food Ordering Platform
Technologies: PHP, MySQL, Bootstrap 5, JavaScript, Omise Payment Gateway
Duration: [Your Duration]

• Developed a full-stack web application enabling multi-vendor cafe ordering with role-based access control (Admin, Shop Owner, Customer)
• Implemented secure user authentication, shopping cart functionality, real-time order tracking, and pre-order scheduling
• Integrated Omise payment gateway for seamless credit/debit card transactions
• Designed normalized MySQL database with stored procedures for revenue analytics and business intelligence
• Built responsive UI using Bootstrap 5 ensuring optimal user experience across mobile and desktop devices
• Features: Multi-shop management, inventory control, order status tracking, payment processing, and analytics dashboard

Key Achievements:
• Reduced order processing time by implementing automated workflow
• Enabled 24/7 ordering capability with pre-order functionality
• Streamlined shop management with dedicated owner dashboard
```

## Testing Checklist

After rebranding, test:
- [ ] Database connection works
- [ ] Login (Admin, Shop, Customer)
- [ ] Browse shops and menus
- [ ] Add items to cart
- [ ] Place order
- [ ] Payment processing
- [ ] Order tracking
- [ ] Admin panel functions
- [ ] Shop owner panel functions
- [ ] All images load correctly
- [ ] All links work with new folder name

## Access URLs After Rebranding

- Main Site: `http://localhost/CafeConnect/`
- Admin Login: `http://localhost/CafeConnect/auth_login.php`
- Customer Registration: `http://localhost/CafeConnect/customer/cust_regist.php`

## Default Credentials (Unchanged)

**Admin:**
- Username: admin
- Password: 12345678

**Customer:**
- Username: keerthi
- Password: keerthi

## Notes

- All database structure remains the same (only name changed)
- No data loss during rebranding
- Existing functionality preserved
- Only branding and naming updated
