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

// Fetch the total number of projects
$totalProjectsSql = "SELECT COUNT(*) as total FROM projects";
$totalProjectsResult = $conn->query($totalProjectsSql);
$totalProjects = $totalProjectsResult->fetch_assoc()['total'];

// Calculate the total number of pages
$totalPages = ceil($totalProjects / $projectsPerPage);

// Get the current page number
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $projectsPerPage;

// Fetch the projects for the current page
$sql = "SELECT * FROM projects ORDER BY upload_datetime DESC LIMIT $offset, $projectsPerPage";
$result = $conn->query($sql);

// Include the HTML structure
// include 'header.html'; // Include your header file
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
        }

        .project-uploader {
            color: #bbb;
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
                echo '<p class="project-header">' . $row['project_header'] . '</p>';
                echo '<p class="project-uploader">Uploaded by: ' . $row['student_id'] . '</p>';
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

        <!-- Include your footer file -->
        <!-- <?php include 'footer.html'; ?> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
