<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "creatithrive";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $student_id = $_POST['student_id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Optional profile fields
    $address = isset($_POST['address']) ? $_POST['address'] : "";
    $skills = isset($_POST['skills']) ? $_POST['skills'] : "";

    // Default profile image
    $profileImage = null; // Initialize to null

    // Check if a file was uploaded
    if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $profileImage = file_get_contents($_FILES['profile_pic']['tmp_name']);
    }

    // Now, insert the user data into the database
    $sql = "INSERT INTO `user`(`name`, `email`, `password`, `student_id`, `address`, `skills`, `profile_pic`)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssb", $name, $email, $password, $student_id, $address, $skills, $profileImage);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();

// Include HTML files after PHP processing
include('sideBar.php');
include('register.html');
?>
