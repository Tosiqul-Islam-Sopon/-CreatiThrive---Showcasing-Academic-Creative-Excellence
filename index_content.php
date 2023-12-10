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
$projectsPerPage = 10;

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

// Loop through the recent projects and display them
while ($row = $result->fetch_assoc()) {
    ?>
    <div class="card my-2">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <a href="viewProject.html">
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row['project_photo']); ?>" alt="Project Image" class="img-fluid rounded-circle">
                    </a>
                    <a href="./profile.php"><p class="text-black">Uploader ID: <?php echo $row['student_id']; ?></p></a>
                </div>
                <div class="col-9">
                    <h3><a href="profile.php" class="text-dark"><?php echo $row['project_header']; ?></a></h3>
                    <p><?php echo $row['project_description']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <?php
}

// Display pagination links
echo '<div class="pagination">';
for ($i = 1; $i <= $totalPages; $i++) {
    echo '<a href="?page=' . $i . '">' . $i . '</a>';
}
echo '</div>';

// Include other HTML files or provide a redirection if needed
include 'sideBar.php';
// include 'uP.html';

// Close the database connection
$conn->close();
?>
