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

if (isset($_POST['projectId'])) {
    $projectId = $_POST['projectId'];

    // Delete the project from the database
    $sqlDelete = "DELETE FROM projects WHERE project_id = $projectId";
    if ($conn->query($sqlDelete) === TRUE) {
        // Project deleted successfully
        echo "Project deleted successfully";
    } else {
        // Error deleting project
        echo "Error: " . $conn->error;
    }
} else {
    // Invalid request
    echo "Invalid request";
}

$conn->close();
?>
