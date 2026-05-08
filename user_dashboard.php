<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>

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

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="navbar">
    <div>
        <strong>Cultural Events System</strong>
    </div>

    <div>
        Welcome, <?php echo $_SESSION['user']; ?> |
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <h2>User Dashboard</h2>

    <div class="cards">

        <div class="card">
            <h3>View Events</h3>
            <p>See all available cultural events</p>
            <a href="view_events.php">Go</a>
        </div>

        <div class="card">
            <h3>Register for Event</h3>
            <p>Join an event you like</p>
            <a href="register_event.php">Register</a>
        </div>

        <div class="card">
            <h3>My Bookings</h3>
            <p>Check your registered events</p>
           <a href="booking.php">View</a>
        </div>

        <div class="card">
            <h3>Suggestion Box</h3>
            <p>Send feedback or ideas</p>
            <a href="#">Submit</a>
        </div>

    </div>

</div>

</body>
</html>