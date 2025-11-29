<?php
session_start();
include("../config/conn_db.php");

if($_SESSION["utype"]!="ADMIN"){
    header("location: ../includes/restricted.php");
    exit(1);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_customer_list.php");
    exit();
}

$c_id = $_POST['c_id'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($new_password !== $confirm_password) {
    header("Location: admin_customer_pwd.php?c_id=$c_id&error=password_mismatch");
    exit();
}

if (strlen($new_password) < 8) {
    header("Location: admin_customer_pwd.php?c_id=$c_id&error=password_too_short");
    exit();
}

// Update password
$stmt = $mysqli->prepare("UPDATE customer SET c_pwd = ? WHERE c_id = ?");
$stmt->bind_param("si", $new_password, $c_id);

if ($stmt->execute()) {
    header("Location: admin_customer_detail.php?c_id=$c_id&up_pwd=1");
} else {
    header("Location: admin_customer_detail.php?c_id=$c_id&up_pwd=0");
}
?>