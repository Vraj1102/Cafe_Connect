<?php
/**
 * CafeConnect Database Connection - Customizable Version
 * Uses cafeconnectdb database for easy customization
 */

// Database configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'cafeconnectdb';  // Updated to use customizable database

// Create connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($mysqli->connect_error) {
    error_log("Database connection failed: " . $mysqli->connect_error);
    header("Location: ../includes/db_error.php");
    exit();
}

// Set charset to UTF-8
$mysqli->set_charset("utf8mb4");

// Application settings
define('SITE_ROOT', realpath(dirname(__FILE__)));
date_default_timezone_set('Asia/Kolkata');

// Function to safely close database connection
function closeConnection($connection) {
    if ($connection && !$connection->connect_error) {
        $connection->close();
    }
}
?>