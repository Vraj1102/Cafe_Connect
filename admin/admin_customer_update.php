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
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$gender = $_POST['gender'];

// Check for duplicate username (excluding current user)
$stmt = $mysqli->prepare("SELECT c_id FROM customer WHERE c_username = ? AND c_id != ?");
$stmt->bind_param("si", $username, $c_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: admin_customer_edit.php?c_id=$c_id&error=username_exists");
    exit();
}

// Check for duplicate email (excluding current user)
$stmt = $mysqli->prepare("SELECT c_id FROM customer WHERE c_email = ? AND c_id != ?");
$stmt->bind_param("si", $email, $c_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: admin_customer_edit.php?c_id=$c_id&error=email_exists");
    exit();
}

// Update customer
$stmt = $mysqli->prepare("UPDATE customer SET c_username = ?, c_email = ?, c_firstname = ?, c_lastname = ?, c_gender = ? WHERE c_id = ?");
$stmt->bind_param("sssssi", $username, $email, $firstname, $lastname, $gender, $c_id);

if ($stmt->execute()) {
    header("Location: admin_customer_detail.php?c_id=$c_id&success=1");
} else {
    header("Location: admin_customer_edit.php?c_id=$c_id&error=update_failed");
}
?>