<?php
session_start();
include("../config/conn_db.php");

if($_SESSION["utype"]!="ADMIN"){
    header("location: ../includes/restricted.php");
    exit(1);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_shop_list.php");
    exit();
}

$s_id = $_POST['s_id'];
$s_name = trim($_POST['s_name']);
$s_location = trim($_POST['s_location']);
$s_email = trim($_POST['s_email']);
$s_phoneno = trim($_POST['s_phoneno']);
$s_openhour = $_POST['s_openhour'];
$s_closehour = $_POST['s_closehour'];
$s_status = $_POST['s_status'];
$s_preorderstatus = $_POST['s_preorderstatus'];

// Use correct column name 's_preorderstatus' and correct bind types (6 strings, 3 integers)
$stmt = $mysqli->prepare("UPDATE shop SET s_name = ?, s_location = ?, s_email = ?, s_phoneno = ?, s_openhour = ?, s_closehour = ?, s_status = ?, s_preorderstatus = ? WHERE s_id = ?");
$stmt->bind_param("ssssssiii", $s_name, $s_location, $s_email, $s_phoneno, $s_openhour, $s_closehour, $s_status, $s_preorderstatus, $s_id);

if ($stmt->execute()) {
    header("Location: admin_shop_detail.php?s_id=$s_id&success=1");
} else {
    header("Location: admin_shop_edit.php?s_id=$s_id&error=1");
}
?>