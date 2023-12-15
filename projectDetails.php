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
// Check if projectId is set in the URL
if(isset($_GET['projectId'])) {
    $projectId = $_GET['projectId'];

    // Fetch project details from the database based on projectId
    $sqlProjectDetails = "SELECT * FROM projects WHERE project_id = $projectId";
    $resultProjectDetails = $conn->query($sqlProjectDetails);

    if ($resultProjectDetails->num_rows > 0) {
        $projectDetails = $resultProjectDetails->fetch_assoc();
        $projectHeader = htmlspecialchars($projectDetails['project_header']);
        $projectPic = $projectDetails['project_photo'];
        $projectDescription = htmlspecialchars($projectDetails['project_description']);
        $projectURL = htmlspecialchars($projectDetails['project_url']);
        // var_dump($projectPic);
        // Add more fields as needed
    } else {
        // Handle the case where the project ID is not found in the database
        die("Project not found");
    }
} else {
    // Handle the case where projectId is not set in the URL
    die("Project ID not provided");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        /* Add your styles here */
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: 'Roboto', sans-serif;
            /* margin-left: 80px; */
            display: flex;
            flex-direction: column; Make the main axis vertical
            align-items: center; Center items horizontally
            /* min-height: 100vh; */
            /* overflow-x: hidden; */
        }

        .navbar {
            margin-left: 80px;
            padding: 8px 8px 8px 8px;
            background-color: #4CAF50;
            color: white;
            position: fixed;
            /* width: 100%; */
            z-index: 1000;
            top: 0;
        }

        .content-container {
            display: flex;
            justify-content: center; /* Center items horizontally */
            align-items: center; /* Center items vertically */
            /* margin-top: 2px; Adjust as needed */
        }

        .project-details-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            text-align: center;
            margin-top: 80px;
        }

        .project-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .project-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .project-url {
            color: #3498db;
            text-decoration: underline;
            margin-top: 20px;
            display: inline-block;
        }

        .project-description {
            text-align: left;
            margin-bottom: 20px;
        }
    </style>
    <title>Project Details</title>
</head>

<body>
    <!-- Continue with your existing HTML structure -->
    <div class="navbar">
        <h3 class="text-white">CreatiThrive - Showcasing Academic & Creative Excellence</h3>
    </div>

    <div class = "content-container">
        <div class="project-details-container">
            <!-- Project Header -->
            <h1 class="project-header"><?php echo $projectHeader; ?></h1>

            <!-- Project Image -->
            <img src="data:image/jpeg;base64,<?php echo base64_encode($projectPic); ?>" alt="Project Image" class="project-image">

            <!-- Project Description -->
            <div class="project-description">
                <p><strong>Description:</strong> <?php echo $projectDescription; ?></p>
            </div>

            <!-- Upload Date -->
            <?php
                // Convert datetime to desired format (day/month/year)
                $uploadDatetime = new DateTime($projectDetails['upload_datetime']);
                $formattedDate = $uploadDatetime->format('d/m/Y');
            ?>
            <p><strong>Upload Date:</strong> <?php echo $formattedDate; ?></p>

            <!-- Upload Time -->
            <?php
                // Convert datetime to desired format (time only)
                $formattedTime = $uploadDatetime->format('H:i:s');
            ?>
            <p><strong>Upload Time:</strong> <?php echo $formattedTime; ?></p>
            
            <!-- Project URL -->
            <p class="project-url"> <a href="<?php echo $projectURL; ?>" target="_blank">Visit the Project</a></p>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
include 'sideBar.php';
?>
