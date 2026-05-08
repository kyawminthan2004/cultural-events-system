<?php
$conn = new mysqli("localhost", "root", "", "ami_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$error = "";

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = "user"; // default role

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);

    if ($stmt->execute()) {
        $message = "Account created successfully!";
    } else {
        $error = "Error creating account.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <style>
        body {
            font-family: Arial;
            text-align: center;
            background: #f4f6f9;
            margin-top: 100px;
        }

        .box {
            display: inline-block;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input {
            padding: 10px;
            margin: 10px;
            width: 250px;
        }

        button {
            padding: 10px 20px;
            background: #2ecc71;
            color: white;
            border: none;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

<h2>Create Account</h2>

<div class="box">

    <?php
    if ($message != "") echo "<p class='success'>$message</p>";
    if ($error != "") echo "<p class='error'>$error</p>";
    ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Create Account</button>
    </form>

    <p>
        Already have an account?  
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>