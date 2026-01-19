<?php
session_start();
include('config/conn_db.php');

$username = $_POST["username"];
$pwd = $_POST["pwd"];
$loginType = $_POST["loginType"] ?? 'customer';

// Sanitize inputs
$username = $mysqli->real_escape_string($username);
$pwd = $mysqli->real_escape_string($pwd);

if ($loginType === 'admin') {
    // Admin login - check admin table
    $query = "SELECT a_id, a_username, a_firstname, a_lastname FROM admin WHERE 
              a_username = '$username' AND a_pwd = '$pwd' AND a_status = 1 LIMIT 1";
    
    $result = $mysqli->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_array();
        $_SESSION["aid"] = $row["a_id"];
        $_SESSION["firstname"] = $row["a_firstname"];
        $_SESSION["lastname"] = $row["a_lastname"];
        $_SESSION["utype"] = "ADMIN";
        
        header("Location: admin/admin_home.php");
        exit();
    } else {
        echo "<script>alert('Invalid admin credentials!'); history.back();</script>";
    }
    
} elseif ($loginType === 'shop') {
    // Shop owner login - check shop table
    $query = "SELECT s_id, s_username, s_name FROM shop WHERE 
              s_username = '$username' AND s_pwd = '$pwd' AND s_status = 1 LIMIT 1";
    
    $result = $mysqli->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_array();
        $_SESSION["sid"] = $row["s_id"];
        $_SESSION["username"] = $username;
        $_SESSION["shopname"] = $row["s_name"];
        $_SESSION["utype"] = "shopowner";
        
        header("Location: shop/shop_home.php");
        exit();
    } else {
        echo "<script>alert('Invalid shop credentials!'); history.back();</script>";
    }
    
} else {
    // Customer login - check customer table
    $query = "SELECT c_id, c_username, c_firstname, c_lastname FROM customer WHERE 
              c_username = '$username' AND c_pwd = '$pwd' LIMIT 1";
    
    $result = $mysqli->query($query);
    if ($result->num_rows == 1) {
        $row = $result->fetch_array();
        $_SESSION["cid"] = $row["c_id"];
        $_SESSION["firstname"] = $row["c_firstname"];
        $_SESSION["lastname"] = $row["c_lastname"];
        $_SESSION["utype"] = "customer";
        
        header("Location: customer/home.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password!'); history.back();</script>";
    }
}

$mysqli->close();
?>