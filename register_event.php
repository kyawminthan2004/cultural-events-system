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

$message = "";

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    $check = $conn->query("SELECT * FROM bookings WHERE user_id=$user_id AND event_id=$event_id");

    if ($check->num_rows > 0) {
        $message = "You have already registered for this event.";
    } else {
        $conn->query("INSERT INTO bookings (user_id, event_id) VALUES ($user_id, $event_id)");
        $message = "Event registered successfully!";
    }
}

$result = $conn->query("SELECT * FROM events WHERE status='Available'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register for Event</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; margin:40px; }
        h2 { color:#2c3e50; }
        table { width:100%; border-collapse:collapse; background:white; margin-top:20px; }
        th { background:#3498db; color:white; padding:12px; }
        td { padding:12px; border:1px solid #ccc; text-align:center; }
        a { color:#3498db; font-weight:bold; text-decoration:none; }
        .message { background:#eafaf1; color:green; padding:10px; margin:15px 0; font-weight:bold; }
    </style>
</head>
<body>

<h2>Register for Event</h2>

<a href="user_dashboard.php">Dashboard</a> |
<a href="booking.php">My Bookings</a> |
<a href="logout.php">Logout</a>

<?php if ($message != "") echo "<div class='message'>$message</div>"; ?>

<table>
<tr>
    <th>ID</th>
    <th>Type</th>
    <th>Description</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['event_id']; ?></td>
    <td><?php echo $row['event_type']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td><?php echo $row['event_date']; ?></td>
    <td>
        <a href="register_event.php?event_id=<?php echo $row['event_id']; ?>">Register</a>
    </td>
</tr>
<?php } ?>

</table>

</body>
</html>