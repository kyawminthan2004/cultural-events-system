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

// Get student ID from URL
$id = $_GET['id'];

// Fetch student data
$result = $conn->query("SELECT * FROM students WHERE student_id=$id");
$row = $result->fetch_assoc();

// Update logic
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $stmt = $conn->prepare("UPDATE students SET student_name=?, student_email=?, course=? WHERE student_id=?");
    $stmt->bind_param("sssi", $name, $email, $course, $id);
    $stmt->execute();

    header("Location: view_students.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student - AMI System</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f4f6f9;
            margin: 40px;
        }

        form {
            width: 350px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input {
            width: 95%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #219150;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h2>Edit Student</h2>

<a href="dashboard.php">Dashboard</a> |
<a href="view_students.php">View Students</a> |
<a href="logout.php">Logout</a>

<hr>

<form method="POST">
    <label>Name</label><br>
    <input type="text" name="name" value="<?= $row['student_name'] ?>" required><br>

    <label>Email</label><br>
    <input type="email" name="email" value="<?= $row['student_email'] ?>" required><br>

    <label>Course</label><br>
    <input type="text" name="course" value="<?= $row['course'] ?>" required><br><br>

    <button type="submit" name="update">Update Student</button>
</form>

</body>
</html>