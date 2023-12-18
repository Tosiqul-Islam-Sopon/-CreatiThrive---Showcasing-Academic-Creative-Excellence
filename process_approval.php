<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['projectId'], $_POST['action'])) {
        $projectId = $_POST['projectId'];
        $action = $_POST['action'];

        // Include your database connection logic here
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "creatithrive";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Perform approval or rejection logic based on $action
        if ($action === 'approve') {
            // Update your database to mark the project as approved
            $sqlUpdate = "UPDATE projects SET status = 'approved' WHERE project_id = $projectId";
            $conn->query($sqlUpdate);

            // Perform additional actions for approval if needed
            // ...

            echo "Project Approved successfully!";
        } elseif ($action === 'reject') {
            // Delete the project from the database
            $sqlDelete = "DELETE FROM projects WHERE project_id = $projectId";
            if ($conn->query($sqlDelete) === TRUE) {
                // Perform additional actions for rejection if needed
                // ...

                echo "Project Rejected and deleted successfully!";
            } else {
                echo "Error deleting project: " . $conn->error;
            }
        } 
        header("Location: pending_posts.php");
        exit();

        // Close the database connection
        $conn->close();
    } else {
        echo "Missing parameters!";
    }
} else {
    echo "Invalid request method!";
}
?>
