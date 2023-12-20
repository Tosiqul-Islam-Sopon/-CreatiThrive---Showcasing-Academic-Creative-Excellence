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
            echo '<script>var passwordError = "Incorrect password";</script>';
        }
    } else {
        echo '<script>var userNotFoundError = "User not found";</script>';
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <!-- Include HTML files after PHP processing -->
    <?php
    // Include HTML files after PHP processing
    include('sideBar.php');
    include('login.html');
    ?>

    <!-- JavaScript to display error messages -->
    <script>
        // Check if the JavaScript variables are set and display messages accordingly
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof passwordError !== 'undefined') {
                document.getElementById('passwordError').innerText = passwordError;
            }
            if (typeof userNotFoundError !== 'undefined') {
                document.getElementById('userNotFoundError').innerText = userNotFoundError;
            }
        });
    </script>
</body>
</html>