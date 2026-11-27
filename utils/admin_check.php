<?php
session_start();
if (empty($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$adminId   = $_SESSION['admin_id'];
$adminName = $_SESSION['admin_name'];
?>