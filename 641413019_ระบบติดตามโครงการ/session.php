<?php
include('includes/config.php');

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

session_start();

$check = $_SESSION['login_email']; // ใช้อีเมลแทนชื่อผู้ใช้

if (!isset($check)) {
    header("Location:index.php");
}
?>
