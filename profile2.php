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
    <link rel="stylesheet" type="text/css" href="profile2.css">
    <style>
        
        /* Add your CSS styles here, or you can link to an external stylesheet */
        /* Ensure the styles match the design of your previous code */
    </style>
    <title>Edit Profile</title>
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
            <div class="featured-works">
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
            </div>

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
            // const userName = document.getElementById('userNameInput').value;
            // const userEmail = document.getElementById('userEmailInput').value;
            // const userAddress = document.getElementById('userAddressInput').value;
            // const userSkills = document.getElementById('userSkillsInput').value;
            // const profileImage = document.getElementById('profileImageInput').files[0];

            // Handle image upload and other data processing here

            // document.getElementById('userName').innerText = userName;
            // document.getElementById('userEmail').innerText = userEmail;
            // document.getElementById('userAddress').innerText = userAddress;
            // document.getElementById('userSkills').innerText = userSkills;
            
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

            // toggleEdit();
            // echo "UserName: userName<br>";
            // echo "UserEmail: userEmail<br>";
            // echo "UserAddress: userAddress<br>";
            // echo "UserSkills: userSkills<br>";

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

        function deleteWork(button) {
            const workItem = button.parentElement;
            workItem.remove();
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
