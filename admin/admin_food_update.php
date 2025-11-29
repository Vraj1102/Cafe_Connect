<?php
session_start();
include("../config/conn_db.php");

if($_SESSION["utype"]!="ADMIN"){
    header("location: ../includes/restricted.php");
    exit(1);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_food_list.php");
    exit();
}

$f_id = $_POST['f_id'];
$f_name = trim($_POST['f_name']);
$f_price = $_POST['f_price'];
$s_id = $_POST['s_id'];
$f_todayavail = $_POST['f_todayavail'];
$f_preorderavail = $_POST['f_preorderavail'];

$stmt = $mysqli->prepare("UPDATE food SET f_name = ?, f_price = ?, s_id = ?, f_todayavail = ?, f_preorderavail = ? WHERE f_id = ?");
$stmt->bind_param("sdiiii", $f_name, $f_price, $s_id, $f_todayavail, $f_preorderavail, $f_id);

if ($stmt->execute()) {
    header("Location: admin_food_detail.php?f_id=$f_id&success=1");
} else {
    header("Location: admin_food_edit.php?f_id=$f_id&error=1");
}
?>