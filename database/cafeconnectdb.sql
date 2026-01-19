-- ========================================================================
-- CafeConnect Customizable Database (cafeconnectdb)
-- Easy to customize - Add your data in the marked sections below
-- ========================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create Database
CREATE DATABASE IF NOT EXISTS `cafeconnectdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `cafeconnectdb`;

-- ========================================================================
-- STORED PROCEDURES (DO NOT MODIFY)
-- ========================================================================

DELIMITER $$

CREATE PROCEDURE `customer_order` (IN `order_id` INT(11))
BEGIN
    SELECT 
        orh.orh_refcode AS reference_code, 
        CONCAT(c.c_firstname,' ',c.c_lastname) AS customer_name, 
        s.s_name AS shop_name,
        f.f_name AS food_name,
        ord.ord_buyprice AS buy_price, 
        ord.ord_amount AS amount,
        ord.ord_note AS order_note, 
        orh.orh_ordertime AS order_time, 
        orh.orh_pickuptime AS pickup_time
    FROM order_header orh 
    INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id
    INNER JOIN customer c ON orh.c_id = c.c_id
    INNER JOIN shop s ON orh.s_id = s.s_id
    WHERE orh.orh_id = order_id; 
END$$

CREATE PROCEDURE `customer_order_history` (IN `customer_id` INT(11))
BEGIN
    SELECT 
        orh.orh_refcode AS reference_code, 
        CONCAT(c.c_firstname,' ',c.c_lastname) AS customer_name,
        s.s_name AS shop_name, 
        orh.orh_ordertime AS order_time, 
        orh.orh_pickuptime AS pickup_time,
        p.p_amount AS order_cost, 
        orh.orh_orderstatus AS order_status
    FROM order_header orh 
    INNER JOIN customer c ON orh.c_id = c.c_id
    INNER JOIN payment p ON orh.p_id = p.p_id
    INNER JOIN shop s ON orh.s_id = s.s_id
    WHERE c.c_id = customer_id;
END$$

CREATE PROCEDURE `shop_alltime_revenue` (IN `shop_id` INT(11))
BEGIN
    SELECT SUM(ord.ord_amount*ord.ord_buyprice) AS alltime_revenue 
    FROM order_header orh 
    INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id 
    INNER JOIN shop s ON s.s_id = orh.s_id
    WHERE s.s_id = shop_id AND orh.orh_orderstatus = 'FNSH';
END$$

CREATE PROCEDURE `shop_menu_revenue` (IN `shop_id` INT(11))
BEGIN
    SELECT 
        f.f_name AS food_name, 
        SUM(ord.ord_amount*ord.ord_buyprice) AS menu_revenue
    FROM order_header orh 
    INNER JOIN order_detail ord ON orh.orh_id = ord.orh_id
    INNER JOIN food f ON f.f_id = ord.f_id
    WHERE orh.s_id = shop_id AND orh.orh_orderstatus = 'FNSH'
    GROUP BY ord.f_id 
    ORDER BY menu_revenue DESC;
END$$

DELIMITER ;

-- ========================================================================
-- TABLE STRUCTURES (DO NOT MODIFY)
-- ========================================================================

-- Customer Table (Only for regular customers)
CREATE TABLE `customer` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_pwd` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_firstname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_lastname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'M for Male, F for Female',
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_username` (`c_username`),
  UNIQUE KEY `c_email` (`c_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Table (Separate table for administrators)
CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `a_pwd` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `a_firstname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `a_lastname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `a_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `a_role` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ADMIN',
  `a_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  PRIMARY KEY (`a_id`),
  UNIQUE KEY `a_username` (`a_username`),
  UNIQUE KEY `a_email` (`a_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Shop Table
CREATE TABLE `shop` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_pwd` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'shop123',
  `s_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_phoneno` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_openhour` time NOT NULL,
  `s_closehour` time NOT NULL,
  `s_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Active, 0=Inactive',
  `s_preorderstatus` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Accepting pre-orders, 0=Not accepting',
  `s_pic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`s_id`),
  UNIQUE KEY `s_username` (`s_username`),
  UNIQUE KEY `s_email` (`s_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Food Table
CREATE TABLE `food` (
  `f_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_id` int(11) NOT NULL,
  `f_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_price` decimal(6,2) NOT NULL,
  `f_todayavail` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Available today, 0=Not available',
  `f_preorderavail` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Available for pre-order, 0=Not available',
  `f_pic` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`f_id`),
  KEY `s_id` (`s_id`),
  CONSTRAINT `food_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cart Table
CREATE TABLE `cart` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `ct_amount` int(11) NOT NULL,
  `ct_note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`ct_id`),
  KEY `c_id` (`c_id`),
  KEY `s_id` (`s_id`),
  KEY `f_id` (`f_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`f_id`) REFERENCES `food` (`f_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payment Table
CREATE TABLE `payment` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_amount` decimal(8,2) NOT NULL,
  `p_method` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'CASH, STRIPE, CARD',
  `p_status` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'PAID, PENDING, FAILED',
  `p_datetime` timestamp NOT NULL DEFAULT current_timestamp(),
  `p_reference` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order Header Table
CREATE TABLE `order_header` (
  `orh_id` int(11) NOT NULL AUTO_INCREMENT,
  `orh_refcode` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `orh_ordertime` timestamp NOT NULL DEFAULT current_timestamp(),
  `orh_pickuptime` datetime NOT NULL,
  `orh_orderstatus` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PEND' COMMENT 'PEND=Pending, ACPT=Accepted, PREP=Preparing, FNSH=Finished, CANC=Cancelled',
  `orh_finishedtime` datetime DEFAULT NULL,
  PRIMARY KEY (`orh_id`),
  KEY `c_id` (`c_id`),
  KEY `s_id` (`s_id`),
  KEY `p_id` (`p_id`),
  CONSTRAINT `order_header_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `customer` (`c_id`) ON DELETE CASCADE,
  CONSTRAINT `order_header_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `shop` (`s_id`) ON DELETE CASCADE,
  CONSTRAINT `order_header_ibfk_3` FOREIGN KEY (`p_id`) REFERENCES `payment` (`p_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order Detail Table
CREATE TABLE `order_detail` (
  `ord_id` int(11) NOT NULL AUTO_INCREMENT,
  `orh_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `ord_amount` int(11) NOT NULL,
  `ord_buyprice` decimal(6,2) NOT NULL COMMENT 'Price snapshot at time of purchase',
  `ord_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ord_id`),
  KEY `orh_id` (`orh_id`),
  KEY `f_id` (`f_id`),
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`orh_id`) REFERENCES `order_header` (`orh_id`) ON DELETE CASCADE,
  CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`f_id`) REFERENCES `food` (`f_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================================
-- CUSTOMIZE YOUR DATA BELOW - ADD/MODIFY AS NEEDED
-- ========================================================================

-- ========================================================================
-- 1. CUSTOMERS DATA - Add your customers here
-- ========================================================================
-- Format: ('username', 'password', 'firstname', 'lastname', 'email', 'gender')
-- Gender: M=Male, F=Female

INSERT INTO `customer` (`c_username`, `c_pwd`, `c_firstname`, `c_lastname`, `c_email`, `c_gender`) VALUES
-- Sample Customers (You can modify/add more)
('customer1', 'password123', 'John', 'Doe', 'john.doe@email.com', 'M'),
('customer2', 'password123', 'Jane', 'Smith', 'jane.smith@email.com', 'F'),
('customer3', 'password123', 'Mike', 'Wilson', 'mike.wilson@email.com', 'M');

-- ADD MORE CUSTOMERS HERE:
-- ('username', 'password', 'firstname', 'lastname', 'email@domain.com', 'M/F'),


-- ========================================================================
-- 2. ADMIN DATA - Add your administrators here
-- ========================================================================
-- Format: ('username', 'password', 'firstname', 'lastname', 'email')

INSERT INTO `admin` (`a_username`, `a_pwd`, `a_firstname`, `a_lastname`, `a_email`) VALUES
-- Default Admin (Required - Do not remove)
('admin', '12345678', 'Admin', 'User', 'admin@cafeconnect.com');


-- ADD MORE ADMINS HERE:
-- ('admin_username', 'password', 'firstname', 'lastname', 'email@domain.com'),


-- ========================================================================
-- 3. SHOPS DATA - Add your shops here
-- ========================================================================
-- Format: ('username', 'shop_name', 'email', 'location', 'phone', 'open_time', 'close_time', 'image_file')

INSERT INTO `shop` (`s_username`, `s_name`, `s_email`, `s_location`, `s_phoneno`, `s_openhour`, `s_closehour`, `s_pic`) VALUES
-- Sample Shops (You can modify/add more)
('greenzy', 'So Greenzy', 'greenzy@gmail.com', 'Watchers Park, Food Court A', '555-0101', '08:00:00', '20:00:00', 'shop1.jpg'),
('capitol', 'Capitol Crust', 'capitol@gmail.com', 'Opp Girls Hostel, Food Court B', '555-0102', '09:00:00', '21:00:00', 'shop2.jpg'),
('utopian', 'Utopian Feast', 'utopian@gmail.com', 'Opp Boys Hostel, Food Court C', '555-0103', '10:00:00', '21:00:00', 'shop3.jpg');


-- ========================================================================
-- 4. FOOD ITEMS DATA - Add your menu items here
-- ========================================================================
-- Format: (shop_id, 'food_name', price, 'image_file')
-- Note: shop_id must match the s_id from shops above (1, 2, 3, etc.)

INSERT INTO `food` (`s_id`, `f_name`, `f_price`, `f_pic`) VALUES

(1, 'Black Coffee', 59.00, 'Black Coffee.jpg'),
(1, 'Caffe Latte', 79.00, 'Caffe Latte.jpg'),
(1, 'Mocha Frappuccino', 169.00, 'Mocha Frappuccino.jpg'),
(1, 'Cappuccino', 69.00, 'Cappuccino.jpg'),
(1, 'Java Chip Frappuccino', 149.00, 'Java Chip Frappuccino.jpg'),
(1, 'Burger', 89.00, 'Burger.jpg'),
(1, 'Cheese Sandwich', 119.00, 'Sandwiches.jpg'),
(1, 'Fries', 99.00, 'Fries.jpg'),


(2, 'Black Coffee', 59.00, 'Black Coffee.jpg'),
(2, 'Caffe Latte', 79.00, 'Caffe Latte.jpg'),
(2, 'Mocha Frappuccino', 169.00, 'Mocha Frappuccino.jpg'),
(2, 'Cappuccino', 69.00, 'Cappuccino.jpg'),
(2, 'Java Chip Frappuccino', 149.00, 'Java Chip Frappuccino.jpg'),
(2, 'Burger', 89.00, 'Burger.jpg'),
(2, 'Cheese Sandwich', 119.00, 'Sandwiches.jpg'),
(2, 'Fries', 99.00, 'Fries.jpg'),


(3, 'Black Coffee', 59.00, 'Black Coffee.jpg'),
(3, 'Caffe Latte', 79.00, 'Caffe Latte.jpg'),
(3, 'Mocha Frappuccino', 169.00, 'Mocha Frappuccino.jpg'),
(3, 'Cappuccino', 69.00, 'Cappuccino.jpg'),
(3, 'Java Chip Frappuccino', 149.00, 'Java Chip Frappuccino.jpg'),
(3, 'Burger', 89.00, 'Burger.jpg'),
(3, 'Cheese Sandwich', 119.00, 'Sandwiches.jpg'),
(3, 'Fries', 99.00, 'Fries.jpg');
-- ADD MORE FOOD ITEMS HERE:
-- (shop_id, 'Food Item Name', price, 'image_file.jpg'),


-- ========================================================================
-- 5. SAMPLE ORDERS (Optional - for testing)
-- ========================================================================
-- You can add sample payment and order data here for testing

-- Sample Payments
INSERT INTO `payment` (`p_amount`, `p_method`, `p_status`, `p_reference`) VALUES
(180.00, 'STRIPE', 'PAID', 'pi_sample_001'),
(110.00, 'CASH', 'PAID', 'CASH_001'),
(215.00, 'STRIPE', 'PAID', 'pi_sample_002');

-- Sample Order Headers
INSERT INTO `order_header` (`orh_refcode`, `c_id`, `s_id`, `p_id`, `orh_pickuptime`, `orh_orderstatus`) VALUES
('202401150000001', 2, 1, 1, '2024-01-15 12:00:00', 'FNSH'),
('202401150000002', 3, 2, 2, '2024-01-15 13:00:00', 'FNSH'),
('202401150000003', 1, 3, 3, '2024-01-15 14:00:00', 'PREP');

-- Sample Order Details
INSERT INTO `order_detail` (`orh_id`, `f_id`, `ord_amount`, `ord_buyprice`, `ord_note`) VALUES
(1, 1, 2, 90.00, ''),
(2, 5, 1, 45.00, ''),
(2, 6, 1, 65.00, ''),
(3, 9, 2, 50.00, ''),
(3, 11, 1, 95.00, ''),
(3, 12, 2, 25.00, '');

-- ========================================================================
-- END OF CUSTOMIZABLE SECTIONS
-- ========================================================================

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- ========================================================================
-- USAGE INSTRUCTIONS:
-- 
-- 1. Import this file in phpMyAdmin to create 'cafeconnectdb' database
-- 2. Update config/conn_db.php to use 'cafeconnectdb' instead of 'cafeconnect'
-- 3. Add your data in the marked sections above
-- 4. Re-import the file whenever you add new data
-- 
-- IMPORTANT: Always backup your database before making changes!
-- ========================================================================