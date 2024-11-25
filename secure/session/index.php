<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Management Example</title>
</head>
<body>

<?php
// PHP code for session handling
function secure_cookie_settings() {
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams['lifetime'],
        'path'     => $cookieParams['path'],
        'domain'   => $cookieParams['domain'],
        'secure'   => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}
secure_cookie_settings();
session_start();

function rotate_session() {
    if (!isset($_SESSION['last_rotation'])) {
        $_SESSION['last_rotation'] = time();
    }
    if (time() - $_SESSION['last_rotation'] > 5) { // 5 seconds
        session_regenerate_id(true);
        $_SESSION['last_rotation'] = time();
    }
}

function check_session_timeout() {
    $session_timeout = 60; // 60 seconds
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['last_activity'] = time();
}

rotate_session();
check_session_timeout();

// Set or retrieve session data
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'User123';
    echo "<p>Session started for " . htmlspecialchars($_SESSION['username']) . ".</p>";
} else {
    echo "<p>Welcome back, " . htmlspecialchars($_SESSION['username']) . ".</p>";
}
?>

<!-- Main content -->
<h1>Welcome to the Secure Session Management Page</h1>
<p>This page demonstrates secure session handling in PHP.</p>
<p>Your session ID rotates every 5 seconds, and the session times out after 60 seconds of inactivity.</p>

</body>
</html>