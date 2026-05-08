<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ami_db");

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    $conn->query("DELETE FROM bookings WHERE booking_id=$booking_id");
}

header("Location: booking.php");
exit();
?>
