<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
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

    <div class="profile-container">
        <form id="editForm" class="edit-form" method="post" action="upload.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imageUploadEdit">Profile Image:</label>
                <input type="file" name="image" id="imageUploadEdit" accept="image/*" onchange="handleImageUpload()">
                <img src=".//Images/niloy2.jpg" alt="Profile Image" id="profileImage" class="img-fluid profile-image">
            </div>

            <!-- Add other user information fields as before -->

            <button type="submit" class="save-btn">Save Changes</button>
            <button type="button" class="cancel-btn" onclick="cancelEdit()">Cancel</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js (required for Bootstrap components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function handleImageUpload() {
            const input = document.getElementById('imageUploadEdit');
            const image = document.getElementById('profileImage');

            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                image.src = e.target.result;
            };

            reader.readAsDataURL(file);
        }

        function cancelEdit() {
            // Redirect back to the profile page or perform other actions
            window.location.href = 'profile2.html';
        }
    </script>

</body>

</html>
