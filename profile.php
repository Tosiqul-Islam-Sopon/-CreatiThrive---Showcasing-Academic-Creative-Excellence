<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .container{
            margin-left: 100px;
            background-color: aqua;
        }
    </style>
</head>

<body>

    <?php include 'sideBar.html'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="https://cdn.jsdelivr.net/npm/fontawesome@6.0.0/assets/img/icon.png"
                            alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px;">
                        <h3 class="mt-3">John Doe</h3>
                        <p>Bio: A brief description about the person goes here.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h2>Projects</h2>
                <ul>
                    <li>Project 1: Description of the first project.</li>
                    <li>Project 2: Description of the second project.</li>
                    <li>Project 3: Description of the third project.</li>
                    <!-- Add more projects as needed -->
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>