<?php
// Database Configuration
// INSTRUCTIONS:
// 1. Copy this file to conn_db.php
// 2. Update the database credentials below

$mysqli = new mysqli("localhost", "root", "", "cafeconnect");

if ($mysqli->connect_errno) {
    include("../includes/db_error.php");
    exit(1);
}
?>
