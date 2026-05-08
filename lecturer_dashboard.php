<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'lecturer') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lecturer Dashboard</title>

    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f4f6f9;
        }

        .navbar {
            background: #2c3e50;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
        }

        .navbar a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
        }

        .container {
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
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
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="navbar">
    <div>
        <strong>Lecturer Panel - Cultural Events System</strong>
    </div>

    <div>
        Welcome, <?php echo $_SESSION['user']; ?> |
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <h2>Lecturer Dashboard</h2>

    <div class="cards">

        <div class="card">
            <h3>Create Class / Event</h3>
            <p>Create new classes, workshops, or performances.</p>
            <a href="add_event.php">Open</a>
        </div>

        <div class="card">
            <h3>My Classes</h3>
            <p>View your events and see registered users.</p>
            <a href="lecturer_events.php">Open</a>
        </div>

        <div class="card">
            <h3>View All Events</h3>
            <p>See all events available in the system.</p>
            <a href="view_events.php">Open</a>
        </div>

        <div class="card">
            <h3>Profile</h3>
            <p>Manage your account details.</p>
            <a href="#">Open</a>
        </div>

    </div>

</div>

</body>
</html>