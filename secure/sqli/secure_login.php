<?php
session_start();
include 'db.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['username'] = $username;
        echo "Login successful!";
    } else {
        echo "Invalid credentials!";
    }
    $stmt->close();
}
$conn->close();
?>
