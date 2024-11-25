<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $password_hash);
        $stmt->fetch();
        if (password_verify($password, $password_hash)) {
            $otp_code = strval(rand(100000, 999999));
            $expires_at = date("Y-m-d H:i:s", strtotime("+10 minutes"));
            $otp_stmt = $conn->prepare("INSERT INTO otp_codes (user_id, otp_code, expires_at) VALUES (?, ?, ?)");
            $otp_stmt->bind_param("iss", $user_id, $otp_code, $expires_at);
            if ($otp_stmt->execute()) {
                echo "OTP generated. Check your email for the code."; 
            } else {
                echo "Error generating OTP.";
            }
            $otp_stmt->close();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username not found.";
    }
    $stmt->close();
}
$conn->close();
?>
