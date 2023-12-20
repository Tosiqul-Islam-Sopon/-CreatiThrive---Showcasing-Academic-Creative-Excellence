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

// Check if the search query is set in the URL
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Fetch projects based on the search query
    $sqlSearch = "SELECT * FROM projects WHERE project_header LIKE '%$searchQuery%' AND status = 'approved'";
    $resultSearch = $conn->query($sqlSearch);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .search-results-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            margin-top: 20px; /* Add margin for spacing from the header */
            margin-left: 50px;
        }

        .search-result-card {
            flex: 0 0 calc(33.33% - 20px); /* Adjust the width based on your desired layout */
            max-width: 300px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px; /* Add margin for spacing between cards */
        }

        .search-result-card:hover {
            transform: scale(1.05);
        }

        .search-result-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .search-result-details {
            padding: 10px;
        }

        .search-result-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .no-results {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: 50px;
        }
    </style>
    <title>Search Results</title>
</head>

<body>
    <h1 class="text-center">Search Results</h1>

    <?php
    // Check if any projects are found
    if ($resultSearch->num_rows > 0) {
    ?>
    <div class="search-results-container">
        <?php
            // Display search results
            while ($row = $resultSearch->fetch_assoc()) {
                $projectId = $row['project_id'];
                $projectHeader = htmlspecialchars($row['project_header']);
                $projectPic = $row['project_photo'];

                // Output the search results
                echo '<div class="search-result-card">';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($projectPic) . '" alt="Project Image" class="search-result-image">';
                echo '<div class="search-result-details">';
                echo '<p class="search-result-header">' . $projectHeader . '</p>';
                echo '<a href="projectDetails.php?projectId=' . $projectId . '">View Details</a>';
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
    <?php
    } else {
        // Display message when no projects are found
        echo '<p class="no-results">No projects found by this name</p>';
    }
    ?>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
} else {
    echo 'No search query provided';
}

// Close the database connection
$conn->close();
include ('sideBar.php');
?>
