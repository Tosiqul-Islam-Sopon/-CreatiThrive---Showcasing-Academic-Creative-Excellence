<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "creatithrive";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    // Assume form is submitted and handle updates

    // Retrieve user ID from the session
    $userId = $_SESSION['user_id'];

    // Update name, email, address, and skills if values are different
    $userName = isset($_POST['userNameInput']) ? $_POST['userNameInput'] : '';
    $userEmail = isset($_POST['userEmailInput']) ? $_POST['userEmailInput'] : '';
    $userAddress = isset($_POST['userAddressInput']) ? $_POST['userAddressInput'] : '';
    $userSkills = isset($_POST['userSkillsInput']) ? $_POST['userSkillsInput'] : '';

    echo "UserName: $userName<br>";
    echo "UserEmail: $userEmail<br>";
    echo "UserAddress: $userAddress<br>";
    echo "UserSkills: $userSkills<br>";

    $updateProfileSql = "UPDATE user SET name = ?, email = ?, address = ?, skills = ? WHERE student_id = ?";
    $stmt = $conn->prepare($updateProfileSql);
    $stmt->bind_param("sssss", $userName, $userEmail, $userAddress, $userSkills, $userId);

    if ($stmt->execute()) {
        echo "Profile information updated successfully.";
    } else {
        echo "Error updating profile information: " . $stmt->error;
    }

    $stmt->close();

    // Update profile picture if provided
    $profileImage = $_FILES['profileImageInput']['tmp_name'];

    if (!empty($profileImage) && $_FILES['profileImageInput']['error'] === UPLOAD_ERR_OK) {
        $profileImageData = file_get_contents($profileImage);

        // Update the user's profile picture in the database
        $updateImageSql = "UPDATE user SET profile_pic = ? WHERE student_id = ?";
        $stmtImage = $conn->prepare($updateImageSql);
        $stmtImage->bind_param("ss", $profileImageData, $userId);


        if ($stmtImage->execute()) {
            echo "Profile picture updated successfully.";
            header("Location: profile2.php");
            exit();
        } else {
            echo "Error updating profile picture: " . $stmtImage->error;
        }

        $stmtImage->close();
    } elseif ($_FILES['profileImageInput']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Handle file upload error
        echo "Error uploading profile picture: " . $_FILES['profileImageInput']['error'];
    }
}

// Close the database connection
$conn->close();
?>
