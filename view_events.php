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

/* SEARCH */
$search = "";

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

$stmt = $conn->prepare("
    SELECT events.*, users.username
    FROM events
    JOIN users ON events.user_id = users.id
    WHERE events.event_type LIKE ?
       OR events.description LIKE ?
       OR events.status LIKE ?
");

$searchTerm = "%" . $search . "%";

$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Events</title>

    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            margin:0;
        }

        .navbar{
            background:#2c3e50;
            color:white;
            padding:18px 30px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .navbar a{
            color:white;
            text-decoration:none;
            margin-left:20px;
            font-weight:bold;
        }

        .container{
            padding:40px;
        }

        h1{
            color:#2c3e50;
            margin-bottom:20px;
        }

        .search-box{
            margin-bottom:20px;
        }

        .search-box input{
            padding:10px;
            width:250px;
            border:1px solid #ccc;
            border-radius:5px;
        }

        .search-box button{
            padding:10px 15px;
            background:#3498db;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        .search-box a{
            margin-left:10px;
            color:#3498db;
            text-decoration:none;
            font-weight:bold;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }

        th{
            background:#3498db;
            color:white;
            padding:15px;
        }

        td{
            padding:14px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        tr:hover{
            background:#f2f2f2;
        }

        .register-btn{
            color:green;
            text-decoration:none;
            font-weight:bold;
        }
    </style>
</head>

<body>

<div class="navbar">

    <div>
        <strong>Cultural Events System</strong>
    </div>

    <div>
        <a href="user_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>

</div>

<div class="container">

<h1>Available Events</h1>

<div class="search-box">

<form method="GET">

    <input type="text"
           name="search"
           placeholder="Search events..."
           value="<?php echo $search; ?>">

    <button type="submit">Search</button>

    <a href="view_events.php">Reset</a>

</form>

</div>

<table>

<tr>
    <th>ID</th>
    <th>Lecturer</th>
    <th>Event Type</th>
    <th>Description</th>
    <th>Status</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>

<tr>

    <td><?php echo $row['event_id']; ?></td>

    <td><?php echo $row['username']; ?></td>

    <td><?php echo $row['event_type']; ?></td>

    <td><?php echo $row['description']; ?></td>

    <td><?php echo $row['status']; ?></td>

    <td><?php echo $row['event_date']; ?></td>

    <td>

        <a class="register-btn"
           href="register_event.php?event_id=<?php echo $row['event_id']; ?>">
           Register
        </a>

    </td>

</tr>

<?php } ?>

</table>

</div>

</body>
</html>