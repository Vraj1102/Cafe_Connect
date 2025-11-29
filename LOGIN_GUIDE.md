# Login System Guide

## New Login Structure

### Central Login Page
**URL:** `http://localhost/Sai Cafe/login.php`

This page provides three login options:
1. **Customer Login** - For customers to browse and order
2. **Shop Owner Login** - For shop owners to manage their shop
3. **Admin Login** - For administrators to manage the system

### Direct Login URLs

#### Customer Login
- **URL:** `http://localhost/Sai Cafe/customer/cust_login.php`
- **Registration:** `http://localhost/Sai Cafe/customer/cust_regist.php`

#### Shop Owner Login
- **URL:** `http://localhost/Sai Cafe/shop/shop_login.php`
- Shop owners cannot self-register (must be added by admin)

#### Admin Login
- **URL:** `http://localhost/Sai Cafe/admin/admin_login.php`
- Admin accounts are created through database

## Default Credentials

### Admin
- **Username:** admin
- **Password:** 12345678
- **Access:** Full system management

### Customer (Sample)
- **Username:** keerthi
- **Password:** keerthi
- **Access:** Browse shops, place orders

### Shop Owner
- Check database for shop credentials
- **Table:** `shop`
- **Fields:** `s_username`, `s_pwd`

## Features

### Customer Features
- Browse available shops
- View menus
- Add items to cart
- Place orders
- View order history
- Manage profile

### Shop Owner Features
- Manage shop profile
- Add/edit/delete menu items
- View and process orders
- View revenue reports
- Update shop status

### Admin Features
- Manage all customers
- Manage all shops
- Manage all food items
- View all orders
- System-wide reports

## Navigation

### From Homepage
- Click "Log In" button → Opens central login page
- Click "Sign Up" button → Opens customer registration

### From Customer Login Page
- Link to Shop Owner login
- Link to Customer registration
- Link to forgot password

## Fixed Issues

✅ Shop login authentication working
✅ Admin login authentication working
✅ Separate login pages for each user type
✅ Central login selection page
✅ All paths corrected
✅ Database connections fixed
✅ Redirects working properly

## Testing

1. **Test Customer Login:**
   - Go to login page
   - Click "Customer Login"
   - Use: keerthi / keerthi
   - Should redirect to homepage with logged-in state

2. **Test Shop Login:**
   - Go to login page
   - Click "Shop Login"
   - Use shop credentials from database
   - Should redirect to shop dashboard

3. **Test Admin Login:**
   - Go to login page
   - Click "Admin Login"
   - Use: admin / 12345678
   - Should redirect to admin dashboard

## Troubleshooting

**Issue:** Login not working
- Check database connection in `config/conn_db.php`
- Verify credentials in database
- Check browser console for errors

**Issue:** Redirect not working
- Clear browser cache
- Check session is started
- Verify paths are correct

**Issue:** Can't access pages after login
- Check session variables
- Verify user type matches page requirements
- Check restricted.php is working
