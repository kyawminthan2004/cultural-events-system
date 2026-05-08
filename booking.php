<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ami_db");

$username = $_SESSION['user'];

$userResult = $conn->query("SELECT id FROM users WHERE username='$username'");
$user = $userResult->fetch_assoc();
$user_id = $user['id'];

$sql = "SELECT bookings.booking_id, events.event_type, events.description, events.status, events.event_date, bookings.booking_date
        FROM bookings
        JOIN events ON bookings.event_id = events.event_id
        WHERE bookings.user_id = $user_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; margin:40px; }
        h2 { color:#2c3e50; }
        table { width:100%; border-collapse:collapse; background:white; margin-top:20px; }
        th { background:#3498db; color:white; padding:12px; }
        td { padding:12px; border:1px solid #ccc; text-align:center; }
        a { color:#3498db; font-weight:bold; text-decoration:none; }
    </style>
</head>
<body>

<h2>My Bookings</h2>

<a href="user_dashboard.php">Dashboard</a> |
<a href="register_event.php">Register for Event</a> |
<a href="logout.php">Logout</a>

<table>
<tr>
    <th>Booking ID</th>
    <th>Event Type</th>
    <th>Description</th>
    <th>Status</th>
    <th>Event Date</th>
    <th>Booked On</th>
    <th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['booking_id']; ?></td>
    <td><?php echo $row['event_type']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td><?php echo $row['event_date']; ?></td>
    <td><?php echo $row['booking_date']; ?></td>
    <td>
    <a href="cancel_booking.php?id=<?php echo $row['booking_id']; ?>"
       onclick="return confirm('Cancel this booking?')">
       Cancel
    </a>
</td>
</tr>
<?php } ?>

</table>

</body>
</html>