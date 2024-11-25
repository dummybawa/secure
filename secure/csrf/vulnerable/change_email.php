<?php
session_start();
$_SESSION['user_id'] = 1;
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $new_email = $_POST['new_email'];
    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    $stmt->bind_param("si", $new_email, $_SESSION['user_id']);
    $stmt->execute();

    echo "Email address updated successfully (vulnerable).";
}
?>
