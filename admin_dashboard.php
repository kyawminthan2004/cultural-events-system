<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f4f6f9;
        }

        .navbar {
            background: #2c3e50;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .container {
            padding: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card a {
            color: #3498db;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="navbar">
    <strong>Admin Panel - Cultural Events System</strong>
    <div>
        Welcome, <?php echo $_SESSION['user']; ?> |
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Admin Dashboard</h2>

    <div class="cards">
        <div class="card">
            <h3>Manage Users</h3>
            <p>View registered users and their roles.</p>
            <a href="view_users.php">Open</a>
        </div>

        <div class="card">
            <h3>Add Event</h3>
            <p>Create cultural events, classes, and performances.</p>
            <a href="add_event.php">Open</a>
        </div>

        <div class="card">
            <h3>Manage Events</h3>
            <p>View and manage all events.</p>
            <a href="view_events.php">Open</a>
        </div>

        <div class="card">
            <h3>View Bookings</h3>
            <p>Monitor user event bookings.</p>
            <a href="admin_bookings.php">Open</a>
        </div>
    </div>
</div>

</body>
</html>