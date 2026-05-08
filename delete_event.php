<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'lecturer')) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ami_db");

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    $conn->query("DELETE FROM bookings WHERE event_id=$event_id");
    $conn->query("DELETE FROM events WHERE event_id=$event_id");
}

if ($_SESSION['role'] == 'lecturer') {
    header("Location: lecturer_events.php");
} else {
    header("Location: view_events.php");
}

exit();
?>