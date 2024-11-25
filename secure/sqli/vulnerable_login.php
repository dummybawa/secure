<?php
session_start();
include 'db.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vulnerable SQL query without prepared statements
    $query = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        echo "Login successful!";
    } else {
        echo "Invalid credentials!";
    }
}
$conn->close();
?>
