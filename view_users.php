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

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Users</title>

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
            width: 80%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        th {
            background: #3498db;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }
    </style>
</head>

<body>

<h2>User List</h2>

<a href="dashboard.php">Dashboard</a> |
<a href="register.php">Register User</a> |
<a href="logout.php">Logout</a>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['role']; ?></td>
    </tr>
    <?php } ?>

</table>

</body>
</html>