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

    // Check if the email belongs to an academic domain
    if (!isValidAcademicEmail($email)) {
        die("Invalid email. Only academic emails are allowed.");
    }

    // Optional profile fields
    $address = isset($_POST['address']) ? $_POST['address'] : "";
    $skills = isset($_POST['skills']) ? $_POST['skills'] : "";

    // Default profile image
    $profileImage = "profile_pic.jpg"; // Initialize to null

    // Check if a file was uploaded
    // if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    //     $profileImage = file_get_contents($_FILES['profile_pic']['tmp_name']);
    // }

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    
</body>
</html>

<?php

// Include HTML files after PHP processing
include('sideBar.php');
include('register.html');

function isValidAcademicEmail($email)
{
    $allowedDomain = "student.just.edu.bd";
    $parts = explode("@", $email);
    if (count($parts) === 2) {
        $domain = $parts[1];
        $idPart = explode(".", $parts[0]);
        return $domain === $allowedDomain && count($idPart) === 2 && $idPart[1] === "cse";
    }
    return false;
}
?>
