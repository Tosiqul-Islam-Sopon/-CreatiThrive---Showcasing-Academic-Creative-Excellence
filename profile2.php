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

// Assume you have a session variable set during login
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Retrieve updated user profile data from the database
    $sqlProfile = "SELECT * FROM user WHERE student_id = $userId";
    $resultProfile = $conn->query($sqlProfile);

    if ($resultProfile->num_rows > 0) {
        $rowProfile = $resultProfile->fetch_assoc();

        $userName = $rowProfile['name'];
        $userEmail = $rowProfile['email'];
        $userAddress = !empty($rowProfile['address']) ? $rowProfile['address'] : "Not provided yet";
        $userSkills = !empty($rowProfile['skills']) ? $rowProfile['skills'] : "Not provided yet";
        $userProfileImage = !empty($rowProfile['profile_pic']) ? base64_encode($rowProfile['profile_pic']) : "default-avatar.jpg";
    } else {
        // Handle the case where the user ID is not found in the database
        die("User not found");
    }

    // Check if any projects are uploaded for the user
    $sqlProjects = "SELECT * FROM projects WHERE student_id = $userId";
    $resultProjects = $conn->query($sqlProjects);
    $projectsArray = array();
    while ($rowProject = $resultProjects->fetch_assoc()) {
        $projectsArray[] = $rowProject;
    }

} else {
    // Redirect or handle the case where the user is not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="profile2.css"> -->
    <style>
        
        /* Add your CSS styles here, or you can link to an external stylesheet */
        /* Ensure the styles match the design of your previous code */
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .navbar {
            margin-left: 80px;
            padding: 8px 8px 8px 8px;
            background-color: #4CAF50;
            color: white;
            position: fixed;
            width: 100%;
            z-index: 1000;
            top: 0;
        }

        .profile-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid #fff;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        
        .edit-btn {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .profile-info {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .form-group input[type="file"] {
            margin-bottom: 0;
        }

        .save-btn,
        .cancel-btn {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #ccc;
            margin-left: 10px;
        }

        .featured-works {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            width: 80%;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            position: relative;
        }

        .featured-works h3 {
            margin-bottom: 10px;
        }

        .featured-works-table {
            width: 100%;
            /* Adjust this value for spacing */
            border-collapse: collapse;
            margin-top: 10px;
        }

        .featured-works-table th,
        .featured-works-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .featured-works-table th {
            background-color: #3498db;
            color: #fff;
        }

        .work-buttons {
            display: flex;
            gap: 5px;
        }


        .delete-btn,
        .edit-work-btn,
        .details-btn,
        .add-work-btn {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        .add-work-btn {
            background-color: #27ae60;
            margin-left: auto;
            display: block;
        }

        .edit-profile-page .featured-works {
            display: none;
        }

        .edit-profile-page .edit-btn {
            display: none;
        }

        .edit-profile-page .profile-image {
            display: none;
        }

        .edit-profile-page .featured-works-table {
            display: none;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .disabled {
            background-color: #ccc; /* Change the background color for disabled buttons */
            color: #666; /* Change the text color for disabled buttons */
            cursor: not-allowed; /* Change the cursor to indicate that the button is not clickable */
        }
        
    </style>
    <title>Profile</title>
</head>

<body>
    <div class="navbar">
        <h3 class="text-white">CreatiThrive - Showcasing Academic & Creative Excellence</h3>
    </div>
    <div class="container">
        <div class="profile-container">
            <!-- Edit Button -->
            <button class="edit-btn" onclick="toggleEdit()">Edit Profile</button>

            <!-- Profile Image -->
            <img src="data:image/jpeg;base64,<?php echo $userProfileImage; ?>" alt="Profile Image" class="img-fluid profile-image">

            <!-- Profile Information -->
            <div class="profile-info" id="profileInfo">
                <h2 class="display-4" id="userName"><?php echo $userName; ?></h2>
                <p><strong>ID:</strong> <span id="userID"><?php echo $userId; ?></span></p>
                <p><strong>Email:</strong> <span id="userEmail"><?php echo $userEmail; ?></span></p>
                <p><strong>Address:</strong> <span id="userAddress"><?php echo $userAddress; ?></span></p>
                <p><strong>Skills:</strong> <span id="userSkills"><?php echo $userSkills; ?></span></p>
            </div>

            <!-- Featured Works -->
            <!-- <div class="featured-works">
                <h3>Featured Works</h3>
                <?php
                if ($resultProjects->num_rows > 0) {
                    while ($rowProject = $resultProjects->fetch_assoc()) {
                        echo '<div class="featured-work-item">';
                        echo '<h4>' . $rowProject['project_header'] . '</h4>';
                        echo '<p>' . $rowProject['project_description'] . '</p>';
                        echo '<button class="edit-work-btn" onclick="editWork(this)">Edit</button>';
                        echo '<button class="delete-btn" onclick="deleteWork(this)">Delete</button>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No project is uploaded yet.</p>';
                }
                ?>
                <button class="add-work-btn"><a href="./uploadProject.php">New Work</a></button>
            </div> -->

            <div class="featured-works">
                <h2 align="left">Featured Works</h2>
                <button class="add-work-btn" onclick="goToAddWorkPage()">Add Work</button>
            </div>
            <!-- Featured Works Table -->
            <table class="featured-works-table">
                <!-- <caption>Featured Work</caption> -->
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (empty($projectsArray)) {
                    echo '<tr><td colspan="4" style="font-size: 25px;">No project is uploaded yet.</td></tr>';
                }
                else{
                    foreach ($projectsArray as $project) {
                        echo '<tr>';
                        echo '<td><a href="projectDetails.php?projectId=' . $project['project_id'] . '">' . htmlspecialchars($project['project_header']) . '</a></td>';
                        echo '<td>' . htmlspecialchars($project['status']) . '</td>';
                        // Check if the status is 'pending'
                        if ($project['status'] === 'pending') {
                            // If the status is 'pending', disable the 'Edit' and 'Delete' buttons
                            echo '<td><button class="edit-work-btn disabled" disabled>Edit</button></td>';
                            echo '<td><button class="delete-btn disabled" disabled>Delete</button></td>';
                        } else {
                            // If the status is not 'pending', enable the 'Edit' and 'Delete' buttons
                            echo '<td><button class="edit-work-btn" onclick="toggleProjectEdit(' . $project['project_id'] . ')">Edit</button></td>';
                            echo '<td><button class="delete-btn" onclick="deleteProject(' . $project['project_id'] . ')">Delete</button></td>';
                        }  

                        echo '</tr>';
                    }
                }
                ?>
            </tbody>

            </table>


            <!-- Edit Form -->
            <form id="editForm" class="edit-form" style="display: none;" action="updateProfile.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="userNameInput">Name:</label>
                    <input type="text" class="form-control" id="userNameInput" name="userNameInput" placeholder="Enter your name" value="<?php echo htmlspecialchars($userName); ?>">
                </div>
                <div class="form-group">
                    <label for="userEmailInput">Email:</label>
                    <input type="email" class="form-control" id="userEmailInput" name="userEmailInput" placeholder="Enter your email" value="<?php echo htmlspecialchars($userEmail); ?>">
                </div>
                <div class="form-group">
                    <label for="userAddressInput">Address:</label>
                    <input type="text" class="form-control" id="userAddressInput" name="userAddressInput" placeholder="Enter your address" value="<?php echo $userAddress !== 'Not provided yet' ? htmlspecialchars($userAddress) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="userSkillsInput">Skills:</label>
                    <input type="text" class="form-control" id="userSkillsInput" name="userSkillsInput" placeholder="Enter your skills" value="<?php echo $userSkills !== 'Not provided yet' ? htmlspecialchars($userSkills) : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="profileImageInput">Profile Image:</label>
                    <input type="file" class="form-control" id="profileImageInput" name="profileImageInput" placeholder="Your Profile Picture" value="<?php echo $userProfileImage !== 'Not provided yet' ? htmlspecialchars($userProfileImage) : ''; ?>">
                </div>
                <button type="submit" class="save-btn" onclick="saveProfile()">Save Changes</button>
                <button type="button" class="cancel-btn" onclick="cancelEdit()">Cancel</button>
            </form>

        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Add your JavaScript functions here (if needed)
        function toggleEdit() {
            const profileInfo = document.getElementById('profileInfo');
            const editForm = document.getElementById('editForm');
            const body = document.body;

            profileInfo.style.display = profileInfo.style.display === 'none' ? 'block' : 'none';
            editForm.style.display = editForm.style.display === 'none' ? 'block' : 'none';

            // Add or remove the 'edit-profile-page' class based on the display status of the edit form
            body.classList.toggle('edit-profile-page', editForm.style.display === 'block');
        }

        function saveProfile() {
           
            const form = document.getElementById('editForm');
            const formData = new FormData(form);
            console.log([...formData]);

            // Handle other data processing here if needed

            fetch('updateProfile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // You can log the response for debugging
                toggleEdit(); // Assuming you want to hide the form after submission
            })
            .catch(error => {
                console.error('Error:', error);
            });


        }

        function cancelEdit() {
            toggleEdit();
        }

        function editWork(button) {
            const workItem = button.parentElement;
            const projectName = workItem.querySelector('h4').innerText;
            const projectDescription = workItem.querySelector('p').innerText;

            const newProjectName = prompt('Edit Project Name:', projectName);
            const newProjectDescription = prompt('Edit Project Description:', projectDescription);

            if (newProjectName !== null && newProjectDescription !== null) {
                workItem.querySelector('h4').innerText = newProjectName;
                workItem.querySelector('p').innerText = newProjectDescription;
            }
        }

        function deleteProject(projectId) {
            // Ask for confirmation before deleting
            if (confirm("Are you sure you want to delete this project?")) {
                fetch('deleteProject.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'projectId=' + encodeURIComponent(projectId),
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    // Assuming the response indicates success, you can update the displayed projects
                    window.location.href = 'profile2.php'; // Fetch updated profile data after project deletion
                })
                .catch(error => {
                    console.error('Error:', error);
                }); 
            }
        }

        function showDetails(projectId) {
            // Add logic to navigate to projectDetails.php with the project ID
            window.location.href = 'projectDetails.php?projectId=' + projectId;
        }

        function toggleProjectEdit(projectId) {
            window.location.href = 'projectEdit.php?projectId=' + projectId;
        }

        function deleteWork(workId) {
            const workItem = document.getElementById(workId);
            workItem.parentNode.removeChild(workItem);
        }

        function goToAddWorkPage() {
            // Add logic to navigate to the page for adding a new work
            window.location.href = 'uploadProject.php'
        }
    </script>

</body>

</html>

<?php
// Close the database connection
$conn->close();

// Include other necessary files if needed
include('sideBar.php');
?>