<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CulturalEvents4Communities Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 40px;
        }

        h2 {
            color: #2c3e50;
        }

        h3 {
            margin-top: 20px;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }

        a:hover {
            color: red;
        }

        hr {
            margin: 15px 0;
        }
    </style>
</head>

<body>

<h2>CulturalEvents4Communities Dashboard</h2>

<p>Welcome, <?php echo $_SESSION['user']; ?></p>

<hr>

<h3>Menu</h3>

<a href="add_user.php">Register User</a> |
<a href="view_users.php">View Users</a> |
<a href="add_event.php">Add Event</a> |
<a href="view_events.php">View Events</a> |
<a href="logout.php">Logout</a>

</body>
</html>