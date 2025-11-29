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

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);
$gender = $_POST['gender'];
$type = $_POST['type'];

// Validation
if ($password !== $confirm_password) {
    header("Location: admin_customer_add.php?error=password_mismatch");
    exit();
}

if (strlen($password) < 8) {
    header("Location: admin_customer_add.php?error=password_too_short");
    exit();
}

// Check for duplicate username
$stmt = $mysqli->prepare("SELECT c_id FROM customer WHERE c_username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: admin_customer_add.php?error=username_exists");
    exit();
}

// Check for duplicate email
$stmt = $mysqli->prepare("SELECT c_id FROM customer WHERE c_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: admin_customer_add.php?error=email_exists");
    exit();
}

// Insert new customer
$stmt = $mysqli->prepare("INSERT INTO customer (c_username, c_pwd, c_firstname, c_lastname, c_email, c_gender, c_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $password, $firstname, $lastname, $email, $gender, $type);

if ($stmt->execute()) {
    header("Location: admin_customer_list.php?add_cst=1");
} else {
    header("Location: admin_customer_list.php?add_cst=0");
}
?>