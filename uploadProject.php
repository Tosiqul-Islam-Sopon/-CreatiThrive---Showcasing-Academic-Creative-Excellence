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

    date_default_timezone_set('Asia/Dhaka');


    // Include the database connection logic and other necessary files
    

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $projectHeader = $_POST['projectHeader'];
        $projectDescription = $_POST['projectDescription'];
        $projectUrl = $_POST['projectUrl'];
        $studentId = $_SESSION['user_id'];  // Assuming user_id is set in the session

        // Process the uploaded image
        // $targetDirectory = "uploads/";
        // $projectPhoto = $targetDirectory . basename($_FILES['projectPhoto']['name']);
        // move_uploaded_file($_FILES['projectPhoto']['tmp_name'], $projectPhoto);

        // // Get the contents of the uploaded image
        // $projectPhotoContents = file_get_contents($projectPhoto);

        $projectPhoto = $_FILES['projectPhoto']['tmp_name'];

        if (!empty($projectPhoto) && $_FILES['projectPhoto']['error'] === UPLOAD_ERR_OK) {
            $projectPhotoContents = file_get_contents($projectPhoto);
        }

        // Get the current date and time
        $uploadDatetime = date("Y-m-d H:i:s");

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO projects (project_header, project_description, project_url, project_photo, student_id, upload_datetime, status) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");

        if (!$stmt) {
            // Reconnect if the statement preparation fails
            $conn->close();
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retry the statement preparation
            $stmt = $conn->prepare("INSERT INTO projects (project_header, project_description, project_url, project_photo, student_id, upload_datetime, status) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
        }

        // Default status for a new project is 'pending'
        $defaultStatus = 'pending';

        $stmt->bind_param("sssssss", $projectHeader, $projectDescription, $projectUrl, $projectPhotoContents, $studentId, $uploadDatetime, $defaultStatus);

        if ($stmt->execute()) {
            echo "Project uploaded successfully!";
            // Redirect to a different page if needed
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
        // Close the database connection
        $conn->close();
    }

    // Include other HTML files or provide a redirection if needed
    include 'sideBar.php';
    include 'uP.html';
?>
