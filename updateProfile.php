<?php
session_start();

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    // Collect form data
    $userId = $_SESSION['user_id'];
    $userName = isset($_POST['userNameInput']) ? $_POST['userNameInput'] : '';
    $userEmail = isset($_POST['userEmailInput']) ? $_POST['userEmailInput'] : '';
    $userAddress = isset($_POST['userAddressInput']) ? $_POST['userAddressInput'] : '';
    $userSkills = isset($_POST['userSkillsInput']) ? $_POST['userSkillsInput'] : '';

    // Process the uploaded image
    $targetDirectory = "uploads/";
    $profileImage = $targetDirectory . basename($_FILES['profileImageInput']['name']);

    if ($_FILES['profileImageInput']['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['profileImageInput']['tmp_name'], $profileImage);
        $profileImageContents = file_get_contents($profileImage);
    } else {
        // Handle the case where no new image is uploaded
        $profileImageContents = null;
    }

    // Use prepared statements to prevent SQL injection
    $updateProfileSql = "UPDATE user SET name = ?, email = ?, address = ?, skills = ?, profile_pic = ? WHERE student_id = ?";
    $stmt = $conn->prepare($updateProfileSql);

    if (!$stmt) {
        // Reconnect if the statement preparation fails
        $conn->close();
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retry the statement preparation
        $stmt = $conn->prepare($updateProfileSql);
    }

    $stmt->bind_param("ssssss", $userName, $userEmail, $userAddress, $userSkills, $profileImageContents, $userId);

    if ($stmt->execute()) {
        echo "Profile information updated successfully.";
        // Redirect or handle success as needed
    } else {
        echo "Error updating profile information: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
