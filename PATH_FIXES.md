# Path Fixes Applied

## Fixed Files

### Root Level
- ✅ `index.php` - Updated all paths to use absolute paths

### Includes Directory
- ✅ `includes/nav_header.php` - Fixed all navigation links
- ✅ `includes/head.php` - Fixed favicon path
- ✅ `includes/check_login.php` - Fixed database connection and redirect
- ✅ `includes/logout.php` - Fixed redirect path

### Customer Directory
- ✅ `customer/cust_login.php` - Fixed all paths
- ✅ `customer/cust_regist.php` - Fixed all paths
- ✅ `customer/shop_list.php` - Fixed all paths

## Path Patterns Used

### Absolute Paths (from root)
```php
// Navigation and links
href="/Sai Cafe/index.php"
href="/Sai Cafe/customer/cust_login.php"
href="/Sai Cafe/customer/shop_list.php"

// Assets
src="/Sai Cafe/assets/img/photo.jpg"
href="/Sai Cafe/assets/css/style.css"
```

### Relative Paths (from subdirectories)
```php
// From customer/ or admin/ or shop/ directories
include("../config/conn_db.php")
include("../includes/head.php")
href="../assets/css/main.css"
```

## Working Features

✅ Home page (index.php)
✅ Login page access
✅ Sign Up page access
✅ Shop List page access
✅ Navigation menu
✅ Logout functionality

## Next Steps

Update remaining files in:
- `customer/*.php` - All other customer files
- `admin/*.php` - All admin files
- `shop/*.php` - All shop files

Use the same pattern:
- Absolute paths for navigation: `/Sai Cafe/...`
- Relative paths for includes: `../config/...`, `../includes/...`
