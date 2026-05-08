<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ami_db");

$sql = "
SELECT 
    events.event_id,
    events.event_type,
    events.description,
    events.status,
    events.event_date,
    creator.username AS lecturer_name,
    booked_user.username AS registered_user,
    bookings.booking_date
FROM events
LEFT JOIN users AS creator ON events.user_id = creator.id
LEFT JOIN bookings ON events.event_id = bookings.event_id
LEFT JOIN users AS booked_user ON bookings.user_id = booked_user.id
ORDER BY events.event_date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Event & Booking Overview</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 40px;
        }

        h2 {
            color: #2c3e50;
        }

        a {
            color: #3498db;
            font-weight: bold;
            text-decoration: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }
    </style>
</head>

<body>

<h2>Admin Event & Booking Overview</h2>

<a href="admin_dashboard.php">Dashboard</a> |
<a href="view_events.php">Manage Events</a> |
<a href="logout.php">Logout</a>

<table>
    <tr>
        <th>Event ID</th>
        <th>Event / Class</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date</th>
        <th>Created By</th>
        <th>Registered User</th>
        <th>Booking Date</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['event_id']; ?></td>
        <td><?php echo $row['event_type']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><?php echo $row['event_date']; ?></td>
        <td><?php echo $row['lecturer_name']; ?></td>
        <td>
            <?php 
            echo $row['registered_user'] ? $row['registered_user'] : "No booking yet"; 
            ?>
        </td>
        <td>
            <?php 
            echo $row['booking_date'] ? $row['booking_date'] : "-"; 
            ?>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>