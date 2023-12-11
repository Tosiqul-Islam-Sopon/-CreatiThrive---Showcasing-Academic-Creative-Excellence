<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreatiThrive - Showcasing Academic & Creative Excellence</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-LzQJd5jWNU5b6OEMpebsG5By/6z6f5n/M0d6O5t37rNhY/d0u8tywp5f5OhzOqF5D" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #4CAF50;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .context {
            margin-left: 50px;
            margin-top: 30px;
        }

        .card {
            border: none;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card img {
            border-radius: 50%;
        }

        .uploader-id {
            color: #28a745; /* Green color for uploader ID */
        }

        .project-name {
            color: #007bff; /* Blue color for project name */
        }

        .project-description {
            color: #6c757d; /* Gray color for project description */
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #4CAF50;
            background-color: #fff;
            border: 1px solid #4CAF50;
            padding: 8px 16px;
            text-decoration: none;
            margin: 0 5px;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #4CAF50;
            color: #fff;
        }
        .navbar {
            margin-left: 80px;
            padding: 8px 8px 8px 70px;  
            background-color: #4CAF50;
            color: white;
            position: fixed;
            /* width: 100%; */
            z-index: 1000;
            top: 0;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h3 class="text-white navbar-brand">CreatiThrive - Showcasing Academic & Creative Excellence</h3>
    </div>

    <div class="container mt-4">
        <div class="row">    
            <div class="context col-12">
                <?php
                    // Include the content from the PHP file
                    include 'index_content.php';
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
