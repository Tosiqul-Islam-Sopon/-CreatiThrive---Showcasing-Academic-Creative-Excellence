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

// Set the number of projects to display per page
$projectsPerPage = 9;

// Fetch the total number of approved projects
$totalApprovedProjectsSql = "SELECT COUNT(*) as total FROM projects WHERE status = 'approved'";
$totalApprovedProjectsResult = $conn->query($totalApprovedProjectsSql);
$totalApprovedProjects = $totalApprovedProjectsResult->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalApprovedProjects / $projectsPerPage);

// Get the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $projectsPerPage;

// Fetch the projects for the current page
$sql = "SELECT * FROM projects WHERE status = 'approved' ORDER BY upload_datetime DESC LIMIT $offset, $projectsPerPage";
$result = $conn->query($sql);

// Include the HTML structure
?>

<!-- Your HTML structure for the home page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f5f5f5; /* Good white background */
            color: #333; /* Black text */
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1, p {
            text-align: center;
            font-weight: bold;
        }

        h1 {
            font-size: 3em;
            margin-bottom: 10px;
            color: #007bff; /* Blue accent color */
        }

        p {
            font-size: 1.5em;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .project-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
        }

        .project-card {
            max-width: 300px;
            border: 1px solid #333; /* Dark border */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
            background: #1a1a1a; /* Dark background color */
            color: #fff; /* White text */
        }

        .project-card:hover {
            transform: scale(1.05);
        }

        .project-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .project-details {
            padding: 10px;
        }

        .project-header {
            font-size: 18px;
            margin-bottom: 10px;
            color: #007bff; /* Blue accent color */
            cursor: pointer; /* Set cursor to pointer */
        }

        .project-uploader {
            color: #bbb;
            /* cursor: pointer; */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to <span style="color: #007bff;">CreatiThrive</span></h1>
        <p>Showcasing Academic & Creative Excellence</p>
        <!-- Your content goes here -->
        <div class="project-container">
            <?php
            // Display the dynamic project content
            while ($row = $result->fetch_assoc()) {
                echo '<div class="project-card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row['project_photo']) . '" alt="Project Image" class="project-image">';
                echo '<div class="project-details">';
                echo '<p class="project-header" onclick="showDetails(' . $row['project_id'] . ')">' . $row['project_header'] . '</p>';
                
                $uploaderId = $row['student_id'];
                $uploaderNameQuery = "SELECT name FROM user WHERE student_id = $uploaderId";
                $uploaderNameResult = $conn->query($uploaderNameQuery);
            
                $uploaderNameRow = $uploaderNameResult->fetch_assoc();
                $uploaderName = $uploaderNameRow['name'];

                if (isset($_SESSION['user_id'])) {
                    $visitorId = $_SESSION['user_id'];
                    // Check if the visitor is the uploader
                    if ($visitorId === $uploaderId) {
                        echo '<p class="project-uploader profile-link" data-userid="' . $uploaderId . '">Uploaded by: <a href="profile2.php">' . $uploaderName . '</a></p>';
                    } else {
                        // echo '<p class="project-header" onclick="showDetails(' . $row['project_id'] . ')">' . $row['project_header'] . '</p>';

                        echo '<p class="project-uploader profile-link" data-userid="' . $uploaderId . '">Uploaded by: <a href="profileVisitor.php?uploaderId=' . $uploaderId . '">' . $uploaderName . '</a></p>';
                    }
                } else {
                    // Visitor is not logged in
                    echo '<p class="project-uploader profile-link" data-userid="' . $uploaderId . '">Uploaded by: <a href="profileVisitor.php?uploaderId=' . $uploaderId . '">' . $uploaderName . '</a></p>';
                }
                echo '</div></div>';
            }
            ?>
        </div>

        <!-- Pagination links -->
        <div class="pagination">
            <?php
            // Display pagination links
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
            ?>
        </div>

        <!-- Include your sidebar file -->
        <?php include 'sideBar.php'; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showDetails(projectId) {
            // Add logic to navigate to projectDetails.php with the project ID
            window.location.href = 'projectDetails.php?projectId=' + projectId;
        }
    </script>


</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
