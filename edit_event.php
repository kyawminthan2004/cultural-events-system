<?php
session_start();

if (!isset($_SESSION['user']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'lecturer')) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ami_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM events WHERE event_id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $type = $_POST['type'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE events SET event_type=?, description=?, status=?, event_date=? WHERE event_id=?");
    $stmt->bind_param("ssssi", $type, $description, $status, $date, $id);
    $stmt->execute();

    if ($_SESSION['role'] == 'lecturer') {
        header("Location: lecturer_events.php");
    } else {
        header("Location: view_events.php");
    }

    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <style>
        body { font-family: Arial; background:#f4f6f9; margin:40px; }
        form { background:white; padding:25px; width:450px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
        input, select, textarea { width:100%; padding:10px; margin:8px 0 16px; box-sizing:border-box; }
        button { background:#3498db; color:white; padding:12px; border:none; width:100%; border-radius:6px; font-weight:bold; }
        a { color:#3498db; font-weight:bold; text-decoration:none; }
    </style>
</head>
<body>

<h2>Edit Event</h2>

<a href="view_events.php">Back to Events</a>

<br><br>

<form method="POST">
    <label>Event Type</label>
    <input type="text" name="type" value="<?php echo $row['event_type']; ?>" required>

    <label>Description</label>
    <textarea name="description" required><?php echo $row['description']; ?></textarea>

    <label>Status</label>
    <select name="status" required>
        <option value="Available" <?php if ($row['status'] == 'Available') echo 'selected'; ?>>Available</option>
        <option value="Fully Booked" <?php if ($row['status'] == 'Fully Booked') echo 'selected'; ?>>Fully Booked</option>
        <option value="Cancelled" <?php if ($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
    </select>

    <label>Date</label>
    <input type="date" name="date" value="<?php echo $row['event_date']; ?>" required>

    <button type="submit" name="update">Update Event</button>
</form>

</body>
</html>