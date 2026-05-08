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

$message = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $stmt = $conn->prepare("INSERT INTO students (student_name, student_email, course) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $course);

    if ($stmt->execute()) {
        $message = "User registered successfully!";
    } else {
        $message = "Error registering user.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register User</title>

    <style>
        body {
            font-family: Arial;
            background-color: #f4f6f9;
            margin: 40px;
        }

        h2 {
            color: #2c3e50;
        }

        form {
            width: 350px;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }

        input {
            width: 95%;
            padding: 10px;
            margin: 8px 0;
        }

        button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h2>Register User</h2>

<a href="dashboard.php">Dashboard</a> |
<a href="view_students.php">View Users</a> |
<a href="logout.php">Logout</a>

<hr>

<?php
if ($message != "") {
    echo "<p class='success'>$message</p>";
}
?>

<form method="POST">
    <label>User Name</label><br>
    <input type="text" name="name" required><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br>

    <label>Role / Course</label><br>
    <input type="text" name="course" placeholder="e.g. Registered User, Lecturer, Manager" required><br><br>

    <button type="submit" name="submit">Register User</button>
</form>

</body>
</html>