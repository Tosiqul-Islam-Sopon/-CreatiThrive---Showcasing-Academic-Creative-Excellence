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
    $student_id = $_POST['id'];
    $password = $_POST['password'];

    // SQL query to retrieve user from the database
    $sql = "SELECT * FROM user WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variable
            session_start();
            $_SESSION['user_id'] = $row['student_id'];
            // Redirect to index.php
            header("Location: index.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}

// Close the database connection
$conn->close();

// Include HTML files after PHP processing
include('sideBar.php');
include('login.html');
?>