<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ami_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$users = $conn->query("SELECT * FROM users");
$message = "";

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("INSERT INTO events (user_id, event_type, description, status, event_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $type, $description, $status, $date);

    if ($stmt->execute()) {
        $message = "Event added successfully!";
    } else {
        $message = "Error adding event.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .container {
            width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .nav {
            text-align: center;
            margin-bottom: 20px;
        }

        .nav a {
            color: #3498db;
            font-weight: bold;
            text-decoration: none;
        }

        label {
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 6px 0 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            height: 90px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .success {
            background: #eafaf1;
            color: green;
            padding: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .error {
            background: #fdecea;
            color: red;
            padding: 10px;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Add Event</h2>

    <div class="nav">
        <a href="dashboard.php">Dashboard</a> |
        <a href="view_events.php">View Events</a> |
        <a href="logout.php">Logout</a>
    </div>

    <?php
    if ($message == "Event added successfully!") {
        echo "<div class='success'>$message</div>";
    } elseif ($message != "") {
        echo "<div class='error'>$message</div>";
    }
    ?>

    <form method="POST">

        <label>Organiser / User</label>
        <select name="user_id" required>
            <option value="">Select User</option>
            <?php while ($row = $users->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['username']; ?>
                </option>
            <?php } ?>
        </select>

        <label>Event Type</label>
        <input type="text" name="type" placeholder="e.g. Acting Class, Writing Workshop, Drama Play" required>

        <label>Event Description</label>
        <textarea name="description" placeholder="Enter event description" required></textarea>

        <label>Status</label>
        <select name="status" required>
            <option>Available</option>
            <option>Fully Booked</option>
            <option>Cancelled</option>
        </select>

        <label>Date</label>
        <input type="date" name="date" required>

        <button type="submit" name="submit">Add Event</button>

    </form>

</div>

</body>
</html>