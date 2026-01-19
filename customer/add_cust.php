<?php
// For inserting new customers to database
include('../config/conn_db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cust_regist.php");
    exit();
}

$pwd = $_POST["pwd"] ?? '';
$cfpwd = $_POST["cfpwd"] ?? '';

if ($pwd != $cfpwd) {
    ?>
    <script>
        alert('Your password does not match.\nPlease enter it again.');
        history.back();
    </script>
    <?php
    exit();
}

$username = trim($_POST["username"] ?? '');
$firstname = trim($_POST["firstname"] ?? '');
$lastname = trim($_POST["lastname"] ?? '');
$gender = $_POST["gender"] ?? '';
$email = trim($_POST["email"] ?? '');
$type = 'STD'; // Default customer type (not stored in current schema)

if ($gender == "-" || empty($username) || empty($firstname) || empty($lastname) || empty($email)) {
    ?>
    <script>
        alert('Please fill all required fields and select your gender!');
        history.back();
    </script>
    <?php
    exit();
}

// Check for duplicating username
$stmt = $mysqli->prepare("SELECT c_username FROM customer WHERE c_username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows >= 1) {
    ?>
    <script>
        alert('Your username is already taken!');
        history.back();
    </script>
    <?php
    exit();
}

// Check for duplicating email
$stmt = $mysqli->prepare("SELECT c_email FROM customer WHERE c_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows >= 1) {
    ?>
    <script>
        alert('Your email is already in use!');
        history.back();
    </script>
    <?php
    exit();
}

// Insert new customer (schema has no c_type column)
$stmt = $mysqli->prepare("INSERT INTO customer (c_username, c_pwd, c_firstname, c_lastname, c_email, c_gender) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $username, $pwd, $firstname, $lastname, $email, $gender);

if ($stmt->execute()) {
    header("Location: cust_regist_success.php");
} else {
    header("Location: cust_regist_fail.php?err=" . $mysqli->errno);
}
?>