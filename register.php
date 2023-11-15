<?php

include('register.html');
include('sideBar.html');

$servername = "localhost";
$username = "root";
$password = "";
$database = "creatithrive";

$conn = new mysqli($servername, $username, $password, $database);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST["name"];
//     $email = $_POST["email"];
//     $id = $_POST["student_id"];
//     $password = $_POST["password"];

//     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//     $sql = "INSERT INTO users (name, email, student_id, password) VALUES ('$name', '$email', '$id', '$hashedPassword')";

//     if ($conn->query($sql) === TRUE) {
//         echo "User registered successfully";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }

if (isset($_POST['submit'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $id = $_POST["student_id"];
    $password = $_POST["password"];

    echo $name;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, student_id, password) VALUES ('$name', '$email', '$id', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "User registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

