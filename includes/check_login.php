<?php
// Simple login check
if (!isset($_SESSION['cid']) && !isset($_SESSION['sid']) && !isset($_SESSION['aid'])) {
    header("Location: /CafeConnect/auth_login.php");
    exit();
}
?>