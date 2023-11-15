<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "creatithrive";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $student_id = $_POST['student_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // SQL query to insert data into the database
    $sql = "INSERT INTO `user`(`name`, `email`, `password`, `student_id`) VALUES ('$name', '$email', '$password', '$student_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();

// Include HTML files after PHP processing
include('sideBar.php');
include('register.html');
?>