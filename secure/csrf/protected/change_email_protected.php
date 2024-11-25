<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verify the CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF validation failed. Request denied.");
    }

    // Proceed to update email if CSRF validation passes
    $new_email = $_POST['new_email'];
    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    $stmt->bind_param("si", $new_email, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();

    echo "Email address updated successfully (protected).";
}
?>
