<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);     
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password_hash, $email);
        if ($stmt->execute()) {
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>