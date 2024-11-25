<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $otp_code = trim($_POST['otp_code']);
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $otp_stmt = $conn->prepare("SELECT otp_code, expires_at FROM otp_codes WHERE user_id = ? ORDER BY expires_at DESC LIMIT 1");
        $otp_stmt->bind_param("i", $user_id);
        $otp_stmt->execute();
        $otp_stmt->bind_result($stored_otp_code, $expires_at);
        $otp_stmt->fetch();
        if ($otp_code === $stored_otp_code && strtotime($expires_at) > time()) {
            echo "OTP verified. Login successful.";
        } else {
            echo "Invalid or expired OTP.";
        }
        $otp_stmt->close();
    } else {
        echo "Username not found.";
    }
    $stmt->close();
}
$conn->close();
?>
