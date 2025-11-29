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

// Delete customer (CASCADE will handle related records)
$stmt = $mysqli->prepare("DELETE FROM customer WHERE c_id = ?");
$stmt->bind_param("i", $c_id);

if ($stmt->execute()) {
    header("Location: admin_customer_list.php?del_cst=1");
} else {
    header("Location: admin_customer_list.php?del_cst=0");
}
?>