<?php
session_start();
// Generate a CSRF token and store it in the session if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Protected Form</title>
</head>
<body>
    <h2>Change Email (Protected)</h2>
    <form id="protectedForm" action="protected/change_email_protected.php" method="POST">
        <!-- CSRF token hidden input -->
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <input type="email" id="emailInput" name="new_email" placeholder="Enter new email" required>
        <input type="submit" value="Change Email">
    </form>

    <script>
        document.getElementById("protectedForm").addEventListener("submit", function(event) {
            // Here we will NOT modify the email to simulate an attack, so it will send what the user typed
            console.log("Form submitted with CSRF token for protection.");
        });
    </script>
</body>
</html>
