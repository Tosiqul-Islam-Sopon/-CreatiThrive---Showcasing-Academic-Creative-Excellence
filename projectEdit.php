<?php
session_start();
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "creatithrive";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectId = $_POST['projectId'];
    $projectHeader = $_POST['editProjectHeader'];
    $projectDescription = $_POST['editProjectDescription'];
    $projectUrl = $_POST['editProjectUrl'];

    $sql1 = "UPDATE projects SET project_header=?, project_description=?, project_url=? WHERE project_id=?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("ssss", $projectHeader, $projectDescription, $projectUrl, $projectId);

    if ($stmt1->execute()) {
        echo "Project updated successfully";
    } else {
        echo "Error updating project: " . $conn->error;
    }
    $stmt1->close();

    // Handle file upload (project image)
    if ($_FILES["editProjectImage"]["size"] > 0) {
        $projectImage = file_get_contents($_FILES["editProjectImage"]["tmp_name"]);
        $sql2 = "UPDATE projects SET project_photo=? WHERE project_id=?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ss", $projectImage, $projectId);

        if ($stmt2->execute()) {
            echo "Project updated successfully";
        } else {
            echo "Error updating project: " . $conn->error;
        }
        $stmt2->close();
    }
    // Echo values for testing
    // echo "Project ID: " . $projectId . "<br>";
    // echo "Project Header: " . $projectHeader . "<br>";
    // echo "Project Description: " . $projectDescription . "<br>";
    // echo "Project URL: " . $projectUrl . "<br>";


    // Redirect back to the original page
    header('Location: profile2.php');
    exit();
}

// Check if projectId is set in the URL
if (isset($_GET['projectId'])) {
    $projectId = $_GET['projectId'];

    $sql = "SELECT * FROM projects WHERE project_id = $projectId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $projectDetails = array(
            'projectHeader' => htmlspecialchars($row['project_header']),
            'projectDescription' => htmlspecialchars($row['project_description']),
            'projectUrl' => htmlspecialchars($row['project_url']),
            'projectImage' => $row['project_photo'],
        );
    } else {
        die("Project not found");
    }
} else {
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

        .edit-form {
            margin-top: 20px;
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            margin-bottom: 20px;
        }

        .edit-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
            text-align: left;
        }

        .edit-form input,
        .edit-form textarea,
        .edit-form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        #projectImagePreview {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .edit-form button {
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-form button.cancel-btn {
            background-color: #ccc;
            margin-left: 10px;
        }
        .edit-form button.save-btn {
            /* background-color: #ccc; */
            margin-left: 10px;
        }
    </style>
    <title>Edit Project</title>
</head>

<body>
    <div class="navbar">
        <h3 class="text-white">CreatiThrive - Showcasing Academic & Creative Excellence</h3>
    </div>
    <!-- Project Edit Form -->
    <div class="container">
        <div class="content-container">
            <form class="edit-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">

                <label for="editProjectHeader">Edit Project Header:</label>
                <input type="text" id="editProjectHeader" name="editProjectHeader" value="<?php echo $projectDetails['projectHeader']; ?>">

                <label for="editProjectDescription">Edit Project Description:</label>
                <textarea id="editProjectDescription" name="editProjectDescription"><?php echo $projectDetails['projectDescription']; ?></textarea>
                
                <label for="editProjectUrl">Edit Project URL:</label>
                <input type="text" id="editProjectUrl" name="editProjectUrl" value="<?php echo $projectDetails['projectUrl']; ?>">

            <!-- Image Upload -->
                <label for="editProjectImage">Edit Project Image:</label>
                <input type="file" id="editProjectImage" name="editProjectImage" accept="image/*">
                <img id="projectImagePreview" src="data:image/jpeg;base64,<?php echo base64_encode($projectDetails['projectImage']); ?>" alt="Project Image Preview">
                <button type="submit" class="save-btn">Save Changes</button>
                <button type="button" onclick="cancelProjectEdit()" class="cancel-btn">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to preview the selected image
        function previewImage() {
            const input = document.getElementById('editProjectImage');
            const preview = document.getElementById('projectImagePreview');

            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Attach the previewImage function to the change event of the file input
        document.getElementById('editProjectImage').addEventListener('change', previewImage);

        function saveProjectEdit() {
            // Add logic to save project edits
            // ...

            // Redirect back to the original page
            window.location.href = 'profile2.php';
        }

        function cancelProjectEdit() {
            // Redirect back to the original page without saving changes
            window.location.href = 'profile2.php';
        }
    </script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
include 'sideBar.php';
?>
