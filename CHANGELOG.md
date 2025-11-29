# Changelog

## Project Restructuring - 2024

### Added
- Created proper directory structure
- Added `config/` directory for configuration files
- Added `includes/` directory for common include files
- Added `customer/` directory for customer-related functionality
- Added `database/` directory for SQL files
- Added `assets/` directory for static resources (css, js, img)
- Added `vendor/` directory for third-party libraries
- Created comprehensive README.md with installation instructions
- Created .gitignore for version control
- Created config.example.php as template

### Changed
- Moved `conn_db.php` to `config/` directory
- Moved `head.php`, `nav_header.php`, `db_error.php` to `includes/` directory
- Moved authentication files to `includes/` directory
- Moved all customer-related files to `customer/` directory
- Moved `saicafe.sql` to `database/` directory
- Moved `css/`, `js/`, `img/` to `assets/` directory
- Renamed `omise-php/` to `vendor/omise-php/`
- Updated file paths in `index.php` to reflect new structure

### Removed
- Deleted `workspace.code-workspace` (IDE-specific file)
- Deleted `omise-php/tests/` (test files not needed in production)
- Deleted `omise-php/yml/` (CI/CD workflow files)
- Deleted `phpcs.xml`, `phpunit.xml`, `composer.json` from omise-php
- Deleted old `README STEPS.txt`

### Directory Structure
```
Sai Cafe/
├── admin/              # Admin panel
├── shop/               # Shop owner panel
├── customer/           # Customer functionality
├── assets/             # Static assets (css, js, img)
├── config/             # Configuration files
├── includes/           # Common includes
├── database/           # Database files
├── vendor/             # Third-party libraries
├── index.php           # Main entry point
├── README.md           # Documentation
├── .gitignore          # Git ignore rules
└── CHANGELOG.md        # This file
```

### Notes
- All file paths have been updated to reflect the new structure
- Database connection file moved to config directory
- Better separation of concerns with organized directories
- Easier to maintain and scale
