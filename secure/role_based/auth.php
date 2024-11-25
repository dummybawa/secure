<?php
// auth.php
session_start();
include 'db.php';

function login($username, $password) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Check if user exists and password matches (password should be hashed in production)
    if ($user && $user['password'] === $password) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role_id'] = $user['role_id'];
        return true;
    }

    return false;
}

// Check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Logout function
function logout() {
    session_destroy();
}
?>
