<?php
session_start();
include('../config/conn_db.php');

$username = $_POST["username"] ?? '';
$pwd = $_POST["pwd"] ?? '';

if (empty($username) || empty($pwd)) {
    ?>
    <script>
        alert('Please enter username and password!');
        history.back();
    </script>
    <?php
    exit();
}

// Prepared statement for shop login
$stmt = $mysqli->prepare("SELECT s_id, s_name FROM shop WHERE s_username = ? AND s_pwd = ? AND s_status = 1 LIMIT 1");
if (!$stmt) {
    ?>
    <script>
        alert('Database error.');
        history.back();
    </script>
    <?php
    exit();
}
$stmt->bind_param('ss', $username, $pwd);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $_SESSION["sid"] = $row["s_id"];
    $_SESSION["username"] = $username;
    $_SESSION["shopname"] = $row["s_name"];
    $_SESSION["utype"] = "shopowner";
    header("Location: shop_home.php");
    exit();
} else {
    ?>
    <script>
        alert("Wrong username and/or password!");
        history.back();
    </script>
    <?php
}
?>