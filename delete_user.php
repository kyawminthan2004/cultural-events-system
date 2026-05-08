<?php
$conn = new mysqli("localhost", "root", "", "ami_db");

$id = $_GET['id'];

$conn->query("DELETE FROM students WHERE student_id=$id");

header("Location: view_students.php");
?>